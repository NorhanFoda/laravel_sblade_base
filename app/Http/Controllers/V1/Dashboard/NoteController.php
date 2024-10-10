<?php

namespace App\Http\Controllers\Api\V1\Web;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Repositories\Contracts\NoteContract;
use Exception;
use Illuminate\Http\JsonResponse;

class NoteController extends BaseApiController
{
    /**
     * NoteController constructor.
     * @param NoteContract $repository
     */
    public function __construct(NoteContract $repository)
    {
        parent::__construct($repository, NoteResource::class);
    }
    /**
     * Store a newly created resource in storage.
     * @param NoteRequest $request
     * @return JsonResponse
     */
    public function store(NoteRequest $request): JsonResponse
    {
        try {
            $note = $this->repository->create($request->validated());
            return $this->respondWithModel($note->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
   /**
    * Display the specified resource.
    * @param Note $note
    * @return JsonResponse
    */
   public function show(Note $note): JsonResponse
   {
       try {
           return $this->respondWithModel($note->load($this->relations));
       }catch (Exception $e) {
           return $this->respondWithError($e->getMessage());
       }
   }
    /**
     * Update the specified resource in storage.
     *
     * @param NoteRequest $request
     * @param Note $note
     * @return JsonResponse
     */
    public function update(NoteRequest $request, Note $note) : JsonResponse
    {
        try {
            $note = $this->repository->update($note, $request->validated());
            return $this->respondWithModel($note->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     * @param Note $note
     * @return JsonResponse
     */
    public function destroy(Note $note): JsonResponse
    {
        try {
            $this->repository->remove($note);
            return $this->respondWithSuccess(__('messages.deleted'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * active & inactive the specified resource from storage.
     * @param Note $note
     * @return JsonResponse
     */
    public function changeActivation(Note $note): JsonResponse
    {
        try {
            $this->repository->toggleField($note, 'is_active');
            return $this->respondWithModel($note->load($this->relations));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}
