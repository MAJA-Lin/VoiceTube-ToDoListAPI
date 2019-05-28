<?php

namespace App\Repositories;

use App\Models\ToDoList;
use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Events\UploadAttachment;

class ToDoListRepository
{
    /**
     * @param array $validatedData
     *
     * @return \App\Models\ToDoList
     */
    public static function createToDo(array $validatedData)
    {
        DB::beginTransaction();
        try {
            $toDo = new ToDoList;
            $toDo->title = $validatedData['title'];
            $toDo->content = $validatedData['content'];
            $toDo->done_at = $validatedData['done_at'];
            $toDo->save();

            if (isset($validatedData['attachment_content'])) {
                $attachment = event(new UploadAttachment(
                    $toDo,
                    $validatedData['attachment_content'],
                    $validatedData['attachment_name'],
                    $validatedData['attachment_description']
                ));
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();

        # For avoiding N+1 query, return to-do list without attachment
        # Could find a better way.
        return $toDo;
    }

    /**
     * @param integer $id To-Do List Id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getToDoList(int $id): \Illuminate\Database\Eloquent\Collection
    {
        $toDo = ToDoList::where('id', '=', $id)->with('attachments')->firstOrFail();
        return $toDo;
    }

    public static function getAllToDoLists(): \Illuminate\Database\Eloquent\Collection
    {
        return ToDoList::with('attachments')->get();
    }

    public static function updateToDoList(ToDoList $toDo, array $updatingData): ToDoList
    {
        $toDo->title = $updatingData['title'];
        $toDo->content = $updatingData['content'];
        $toDo->done_at = $updatingData['done_at'];
        $toDo->save();

        return $toDo;
    }

    public static function deleteToDoList(ToDoList $todo): bool
    {
        DB::beginTransaction();

        try {
            $todo->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();
        return true;
    }

    public static function deleteAllToDoLists(): \Illuminate\Database\Eloquent\Collection
    {
        DB::beginTransaction();

        try {
            # time complexity: O(n)
            # Maybe just use raw SQL
            $result = ToDoList::all()->each(function ($todo) {
                $todo->delete();
            });
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();
        return $result;
    }
}
