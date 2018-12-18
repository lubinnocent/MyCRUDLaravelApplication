@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .btn {
      background-color: DodgerBlue;
      border: none;
      color: white;
      padding: 12px 16px;
      font-size: 16px;
      cursor: pointer;
    }
    .btn:hover {
      background-color: RoyalBlue;
    }
    </style>
<div class="container">
        <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">My Products</div>
                        <div class="panel-body">
@if (count($products)> 0)
  @foreach ($products as $product)
  <div class="well">
  <div class="row">
    <div class="col-sm-2">
    <img src="local/storage/app/public/cover_images/{{$product->image}}" style="width:100%"/>
    </div>
    <div class="col-sm-8">  
{{$product->name}}<br>
<small>Price (UGX): {{number_format($product->price)}}</small><br/>
<small>Added on: {{$product->created_at}}</small><br/>
</div>
  </div>
<hr>
<small><a href="products/{{$product->id}}/edit" style="padding:8px; text-decoration:none;" class="btn-success fa fa-edit"> Edit</a></small>
{!!Form::open(['action' => ['ProductsController@destroy', $product->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
{{Form::submit('Delete',['class' => 'btn-danger fa fa-trash', 'style' => 'padding:5px'])}}
{{Form::hidden('_method','DELETE')}}
{!!Form::close()!!}
<br/>
</div>
  @endforeach  
  @else
      <h1>No Products added yet !!</h1>
  @endif
  {{$products->links()}}
                </div>
        </div>
</div>
        </div>
</div>
@endsection