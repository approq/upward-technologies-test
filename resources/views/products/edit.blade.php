@extends('layouts.app')

@section('content')
    <products-edit :product-id="{{ $product_id }}" />
@endsection
