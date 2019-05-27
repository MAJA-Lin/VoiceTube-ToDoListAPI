<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use App\Repositories\ToDoListRepository;
use App\Http\Requests\ToDoListRequest;
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
     * @param ToDoListRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createToDoList(ToDoListRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $title = $validatedData['title'];
            $content = $validatedData['content'];

            # TODO: Multiple attachments uploading?
            $attachment = $validatedData['attachment'];

            $result = ToDoListRepository::createToDo($title, $content, $attachment);
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
     * @param ToDoListRequest $request
     * @param \App\Models\ToDoList $toDoList
     * @return \Illuminate\Http\Response
     */
    public function updateToDoList(ToDoListRequest $request, ToDoList $toDoList)
    {
        try {
            $result = ToDoListRepository::updateToDoList($toDoList, $request->all());
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
