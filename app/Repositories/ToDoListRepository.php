<?php

namespace App\Repositories;

use App\Models\ToDoList;
use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class ToDoListRepository
{
    /**
     * @param string $title
     * @param string $content
     * @param string $attachment This can be file or file path.
     *
     * @return \App\Models\ToDoList
     */
    public static function createToDo(string $title, string $content, string $attachment)
    {
        DB::beginTransaction();
        try {
            $toDo = new ToDoList;
            $toDo->title = $title;
            $toDo->content = $content;
            $toDo->save();

            $attach = new Attachment();
            $attach->path = $attachment;
            $toDo->attachments()->save($attach);
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
        $toDo = ToDoList::where('id', '=', $id)->with('attachments')->get();
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

        # TODO: Use validator to make sure done_at is timestamp
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
