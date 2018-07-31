@extends('platform::layouts.dashboard')


@section('title',$name)
@section('description',$description)



@section('navbar')
    <div class="text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('platform.systems.users.create')}}" class="btn btn-link"><i
                        class="icon-plus text-2x"></i></a>
        </div>
    </div>
@stop



@section('content')


    <!-- main content  -->
    <section>
        <div class="bg-white-only bg-auto no-border-xs">

            @include('platform::container.posts.filter')

            @if($users->count() > 0)

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="w-xs">{{trans('platform::common.Manage')}}</th>
                            @foreach($entity->grid() as $th)
                                <th width="{{$th->width}}">{{$th->title}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('platform.systems.users.edit',$user->id) }}"><i
                                                class="icon-menu"></i></a>
                                </td>

                                @foreach($entity->grid() as $td)
                                    <td>
                                        @if(!is_null($td->render))
                                            {!! $td->handler($user) !!}
                                        @else
                                            {{ $user->getContent($td->name) }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>

                <footer class="card-footer">
                    <div class="row">
                        <div class="col-sm-5">
                            <small class="text-muted inline m-t-sm m-b-sm">
                                {{trans('platform::common.show')}} {{($users->currentPage()-1)*$users->perPage()+1}} -
                                {{($users->currentPage()-1)*$users->perPage()+count($users->items())}} {{trans('platform::common.of')}} {!! $users->total() !!} {{trans('platform::common.elements')}}

                            </small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                            {!! $users->links('platform::partials.pagination') !!}
                        </div>
                    </div>
                </footer>

            @else

                <div class="text-center bg-white app-content-center">
                    <div>
                        <h3 class="font-thin">{{trans('platform::systems/users.not_found')}}</h3>

                        <a href="{{ route('platform.systems.roles.create')}}" class="btn btn-link">
                            {{trans('platform::systems/users.create')}}
                        </a>
                    </div>
                </div>

            @endif

        </div>
    </section>
    <!-- / main content  -->


@stop




