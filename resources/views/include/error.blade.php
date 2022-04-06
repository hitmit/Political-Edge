@if (isset($errors) && !empty($errors->all()))
<?php
$errorsToDisplay = $errors->all();
$errorsToDisplay = array_unique($errorsToDisplay);

?>

<div class="alert alert-danger text-left">
    Please correct the following errors before moving forward.
    <ul>
        @foreach ($errorsToDisplay as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div id="floating-top-right" class="floating-container">
    @if(Session::has('warning'))
    <div id="closeAlert" class="alert alert-box alert-warning">
        <button type="button" class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
        {{ Session::get('warning') }}
        <?php Session::forget('warning'); ?>
    </div>
    @endif
    @if(Session::has('message'))
    <div id="closeAlert" class="alert alert-box alert-success">
        <button type="button" class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
        {{ Session::get('message') }}
        <?php Session::forget('message'); ?>
    </div>
    @endif
    @if(Session::has('error'))
    <div id="closeAlert" class="alert alert-box alert-danger">
        <button type="button" class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
        {{ Session::get('error') }}
        <?php Session::forget('error'); ?>
    </div>
    @endif

    <div id="customsuccess" style="display: none" class="alert alert-success">
        <button type="button" class="close" onclick="$('.alert').hide()"><i class="pci-cross pci-circle"></i></button>
        <div class="message">
            Success
        </div>
    </div>

    <div id="customerror" style="display: none" class="alert alert-danger">
        <button type="button" class="close" onclick="$('.alert').hide()"><i class="pci-cross pci-circle"></i></button>
        <div class="message">
            Success
        </div>
    </div>
</div>
