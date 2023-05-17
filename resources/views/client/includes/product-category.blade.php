@foreach ($products as $product)
    <div class="col-lg-3 col-md-4 col-xs-6 item {{ str_replace(' ', '', \App\Models\Author::find($product->author_id)->name) }}">
        <div class="card">
            <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="motsanpham"
                style="text-decoration: none; color: black;" data-toggle="tooltip" data-placement="bottom"
                title="{{ $product->name }}">
                <img class="card-img-top anh" src="{{ asset($product->image->first()->url) }}"
                    alt="{{ $product->name }}">
                <div class="card-body noidungsp mt-3 text-center">
                    <h6 class="card-title ten">{{ $product->name }}</h6>
                    <small class="tacgia text-muted">{{ \App\Models\Author::find($product->author_id)->name }}</small>
                    <div class="gia">
                        @if (strtotime(date('Y-m-d')) < strtotime($product->start_date) || strtotime(date('Y-m-d')) > strtotime($product->end_date))
                            <div class="giamoi text-center">{{ number_format($product->price, -3, ',', ',') }}
                                VND</div>
                        @else 
                            <div class="giamoi">{{ number_format($product->sale_price,-3,',',',') }} VND</div>
                            <small class="text-secondary"><del>{{ number_format($product->price,-3,',',',') }} VND</del></small>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    </div>
@endforeach
