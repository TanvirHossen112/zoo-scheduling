<?php

namespace App\Http\Controllers;

use App\Http\Actions\V1\VisitorScheduleAction;
use App\Http\Requests\V1\VisitorScheduleApiRequest;
use App\Http\Resources\V1\VisitorScheduleResource;
use DB;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Throwable;

class ScheduleController extends Controller
{
    /**
     * Show the visitor schedule form
     *
     * @return Factory|View|\Illuminate\View\View
     */
    public function index()
    {
        return view("pages.schedule-form");
    }

    /**
     * Store visitor schedule
     *
     * @param VisitorScheduleApiRequest $request
     * @param VisitorScheduleAction $visitorScheduleAction
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(VisitorScheduleApiRequest $request, VisitorScheduleAction $visitorScheduleAction)
    {
        try {
            DB::beginTransaction();
            $response = $visitorScheduleAction->execute($request->validated());
            logger()->info("Visitor schedule store : " . json_encode($response));
            DB::commit();

            return $this->successResponse(
                data: new VisitorScheduleResource($response),
                message: "Visitor schedule created successfully",
                code: 201
            );
        } catch (Exception $e) {
            logger()->critical("Visitor schedule store : {$e->getMessage()}");
            return $this->errorResponse(message: "Oops! Something went wrong");
        }
    }
}
