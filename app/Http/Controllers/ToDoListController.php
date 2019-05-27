<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use App\Repositories\ToDoListRepository;
use App\Http\Validators\ToDoListValidator;
use Illuminate\Http\Request;

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
            $result = ToDoListRepository::getAllToDoLists();
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
            $result = ToDoListRepository::createToDo($validatedData);
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
            $result = ToDoListRepository::getToDoList($toDoListId);
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
            $result = ToDoListRepository::deleteAllToDoLists();
        } catch (\Throwable $th) {
            $result = $th;
        }

        return response()->custom($result);
    }
}
