<?php

use AssetUnion\AssetUnion;
use App\Components\ViewInserter;

?><!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta-tags')

    <title>@yield('page-title')</title>

    <?php
    $cssUnion = (new AssetUnion(['/css/app.css', '/css/bootstrap.min.css', '/css/common.css', '/css/font.css']))
        ->setOutput(public_path('/css/union.css'))->rebuildIfNeeded();
    $cssUnion->save();

    ViewInserter::insertCssFile('/css/normalize.css');
    ViewInserter::insertCssFile('/css/union.css')
    ?>


    @section('head-css')
        @foreach(ViewInserter::getCssFiles() as $file)
            @if (!$cssUnion->containsFile($file))
                <link rel="stylesheet" href="{{ $file }}">
            @endif
        @endforeach
    @show

    <style>
        <?= join('\\n', ViewInserter::getInlineCss()) ?>
    </style>

    @yield('head-js')

</head>
<body class="antialiased @yield('body-class')">
<a id="page-start"></a>
@section('top')
    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
        Build v{{ Illuminate\Foundation\Application::VERSION }}
    </div>
@show

@yield('content')

@section('footer')
    @include('_templates/footer')
@show

<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?= join("\n", ViewInserter::getInlineScripts()) ?>
    })
</script>

<?php
$jsUnion = (new AssetUnion([
    '/js/bootstrap.bundle.min.js',
    '/js/system.js',
    '/js/common-routines.js',
    '/js/widgets/contact-form.js'
]))->setOutput(public_path('/js/union.js'))
    ->rebuildIfNeeded()
    ->modifyResult(fn($data) => \JShrink\Minifier::minify($data));

$jsUnion->save();
?>

<script src="/js/union.js"></script>

@foreach(ViewInserter::getScriptFiles() as $file)
    @if (!$jsUnion->containsFile($file))
        <script src="{{ $file }}"></script>
    @endif
@endforeach
</body>
</html>
