@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.segobra.actions.edit', ['name' => $segobra->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <segobra-form
                :action="'{{ $segobra->resource_url }}'"
                :data="{{ $segobra->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.segobra.actions.edit', ['name' => $segobra->SEOBProy]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.segobra.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </segobra-form>

        </div>


</div>

@endsection
