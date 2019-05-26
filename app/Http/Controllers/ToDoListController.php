<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use App\Repositories\ToDoListRepository;
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
            throw $th;
        }

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource. Now only support upload single attachment
     *
     * @return \Illuminate\Http\Response
     */
    public function createToDoList(Request $request)
    {
        try {
            $title = $request->get('title');
            $content = $request->get('content');
            $attachment = $request->get('attachment');

            $result = ToDoListRepository::createToDo($title, $content, $attachment);
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json($result);
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
            throw $th;
        }

        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\ToDoList $toDoList
     * @return \Illuminate\Http\Response
     */
    public function updateToDoList(Request $request, ToDoList $toDoList)
    {
        try {
            $result = ToDoListRepository::updateToDoList($toDoList, $request->all());
        } catch (\Throwable $th) {
            throw $th;
        }

        return response()->json($request);
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
            throw $th;
        }

        return response()->json($result);
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
            throw $th;
        }

        return response()->json($result);
    }
}
