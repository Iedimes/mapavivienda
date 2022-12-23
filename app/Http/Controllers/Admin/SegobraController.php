<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Segobra\BulkDestroySegobra;
use App\Http\Requests\Admin\Segobra\DestroySegobra;
use App\Http\Requests\Admin\Segobra\IndexSegobra;
use App\Http\Requests\Admin\Segobra\StoreSegobra;
use App\Http\Requests\Admin\Segobra\UpdateSegobra;
use App\Models\Segobra;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SegobraController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSegobra $request
     * @return array|Factory|View
     */
    public function index(IndexSegobra $request)
    {
        // create and AdminListing instance for a specific model and
        //$request->merge(['orderBy' => 'SEOBId']);
        $noestados = ['A', 'I'];
        $addprogramas = [4, 11, 5, 2, 3, 1];
        $ids = [6, 10, 12];

        $data = AdminListing::create(Segobra::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['SEOBId', 'SEOBProy','SEOBEmpr'],

            // set columns to searchIn
            ['SEOBId','SEOBProy'],

            function ($query) use ($request,$noestados,$addprogramas,$ids) {
                $query->whereNotIn('SEOBEst', $noestados);
                $query->whereIn('SEOBProgr', $addprogramas);
                $query->whereIn('SEOBPlan', $ids);
                //$query->orderBy('SEOBId');
            }

        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('SEOBId')
                ];
            }
            return ['data' => $data];
        }
        //$data

        return view('admin.segobra.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.segobra.create');

        return view('admin.segobra.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSegobra $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSegobra $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Segobra
        $segobra = Segobra::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/segobras'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/segobras');
    }

    /**
     * Display the specified resource.
     *
     * @param Segobra $segobra
     * @throws AuthorizationException
     * @return void
     */
    public function show(Segobra $segobra)
    {
        $this->authorize('admin.segobra.show', $segobra);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Segobra $segobra
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Segobra $segobra)
    {
        $this->authorize('admin.segobra.edit', $segobra);

        $mediaItems = $segobra->getMedia('gallery');
        //dd($mediaItems);

        return view('admin.segobra.edit', [
            'segobra' => $segobra,
            'mediaItems' => $mediaItems
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSegobra $request
     * @param Segobra $segobra
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSegobra $request, Segobra $segobra)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Segobra
        $segobra->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/segobras'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/segobras');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySegobra $request
     * @param Segobra $segobra
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySegobra $request, Segobra $segobra)
    {
        $segobra->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySegobra $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySegobra $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Segobra::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
