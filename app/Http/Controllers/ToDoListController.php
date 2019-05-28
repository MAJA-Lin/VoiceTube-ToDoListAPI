<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use App\Repositories\ToDoListRepository;
use App\Http\Validators\ToDoListValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ToDoListController extends Controller
{
    /**
     * Get all to-do lists
     *
     * @return \Illuminate\Http\Response
     */
    public function listAll(Request $request)
    {
        try {
            $result = ToDoListRepository::getAllToDoLists(Auth::user());
        } catch (\Throwable $th) {
            $result = $th;
        }

        return response()->custom($result);
    }

    /**
     * Create a new resource. Now only support upload single attachment
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createToDoList(Request $request)
    {
        try {
            $validatedData = ToDoListValidator::validateToDoList($request->all());
            $result = ToDoListRepository::createToDo(Auth::user(), $validatedData);
        } catch (\Throwable $th) {
            $result = $th;
        }

        return response()->custom($result);
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param integer $toDoListId
     * @return \Illuminate\Http\Response
     */
    public function showToDoList(Request $request, int $toDoListId)
    {
        try {
            $result = ToDoListRepository::getToDoList(Auth::user(), $toDoListId);
        } catch (\Throwable $th) {
            $result = $th;
        }

        return response()->custom($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ToDoList $toDoList
     * @return \Illuminate\Http\Response
     */
    public function updateToDoList(Request $request, ToDoList $toDoList)
    {
        try {
            $this->checkUserPermission($toDoList);

            $validatedData = ToDoListValidator::validateToDoList($request->all());
            $result = ToDoListRepository::updateToDoList($toDoList, $validatedData);
        } catch (\Throwable $th) {
            $result = $th;
        }

        return response()->custom($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param \App\Models\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function deleteToDoList(Request $request, ToDoList $toDoList)
    {
        try {
            $this->checkUserPermission($toDoList);

            $result = ToDoListRepository::deleteToDoList($toDoList);
        } catch (\Throwable $th) {
            $result = $th;
        }

        return response()->custom($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param \App\Models\ToDoList  $toDoList
     * @return \Illuminate\Http\Response
     */
    public function deleteAllToDoList(Request $request)
    {
        try {
            $result = ToDoListRepository::deleteAllToDoLists(Auth::user());
        } catch (\Throwable $th) {
            $result = $th;
        }

        return response()->custom($result);
    }

    protected function checkUserPermission(ToDoList $todoList)
    {
        if ($todoList->user->id !== Auth::user()->id) {
            throw new AccessDeniedHttpException("You don't have access.");
        }
    }
}
