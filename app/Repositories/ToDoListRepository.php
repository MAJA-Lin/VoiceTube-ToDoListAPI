<?php

namespace App\Repositories;

use App\Models\ToDoList;
use App\Models\Attachment;
use Illuminate\Support\Facades\DB;
use App\Events\UploadAttachment;

class ToDoListRepository
{
    /**
     * @param \App\Models\User $user
     * @param array $validatedData
     *
     * @return \App\Models\ToDoList
     */
    public static function createToDo(\App\Models\User $user, array $validatedData)
    {
        DB::beginTransaction();
        try {
            $toDo = new ToDoList;
            $toDo->title = $validatedData['title'];
            $toDo->content = $validatedData['content'];
            $toDo->done_at = $validatedData['done_at'];
            $toDo->user_id = $user->id;
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
     * @param \App\Models\User $user
     * @param integer $id To-Do List Id
     * @return ToDoList
     */
    public static function getToDoList(\App\Models\User $user, int $id): ToDoList
    {
        $toDo = ToDoList::byUserId($user->id)->where('id', '=', $id)->with('attachments')->firstOrFail();
        return $toDo;
    }

    public static function getAllToDoLists(\App\Models\User $user): \Illuminate\Database\Eloquent\Collection
    {
        return ToDoList::byUserId($user->id)->with('attachments')->get();
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

    public static function deleteAllToDoLists(\App\Models\User $user): bool
    {
        DB::beginTransaction();

        try {
            ToDoList::byUserId($user->id)->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();
        return true;
    }
}
