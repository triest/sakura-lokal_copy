@extends('layouts.blog', ['title' => 'Сброс пароля по SMS'])

@section('content')
    <div class="card-body" id="powerApp">
        <phonecomponent></phonecomponent>
    </div>
@endsection
<script>
    import PhoneComponent from "./phoneComponent";
    export default {
        components: {PhoneComponent}
    }
</script>