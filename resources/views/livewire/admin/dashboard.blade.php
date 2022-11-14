<div>
    @livewire('admin.breadcrumb',['page' => $page])
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                @foreach($cards as $key => $card)
                <div class="col-lg-3 col-6">
                    <div class="small-box {{$card['class']}}">
                        <div class="inner">
                            <h3>{{$card['count']}}</h3>

                            <p>{{$key}}</p>
                        </div>
                        <div class="icon">
                            <i class="{{$card['icon']}}"></i>
                        </div>
                        <a href="{{$card['route']}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>