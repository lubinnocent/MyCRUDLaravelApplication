@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Product</div>
                <div class="panel-body">
                    {!! Form::open(['action' => ['ProductsController@update', $product->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                    {{Form::label('title','Product Name')}}
                    {{Form::text('product_name',$product->name,['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                    {{Form::label('price','Price (UGX)')}}
                    {{Form::number('product_price',$product->price,['class' => 'form-control', 'min' => '1000'])}}
                </div>
                <div class="form-group">
                    {{Form::label('image','Image')}}
                    {{Form::file('cover_image', ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                        {{Form::hidden('_method','PUT')}}
                    {{Form::submit('Edit',['class' => 'btn btn-primary'])}}  
                </div>
                    {!! Form::close() !!}   
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection