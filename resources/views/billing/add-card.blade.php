@extends('layout')

@section('title', 'Setup payment info')

@section('content')

    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Setup payment info</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Card details</h4>

                    <form class="form-horizontal" role="form" method="post" action="{{ route('site.billing.saveCard') }}"
                          data-eway-encrypt-key="{{ config('eway.encryptKey') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-holder-name">Name on Card</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="input-holder-name" name="holder-name" value="{{ old('holder-name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-card-number">Card Number</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="input-card-number" name="EWAY_CARDNUMBER" value="{{ old('card-number') }}" data-eway-encrypt-name="EWAY_CARDNUMBER">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="select-expiry-month">Expiration Date</label>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <select class="form-control col-sm-2" id="select-expiry-month" name="expire-month">
                                            <option>Month</option>
                                            <option value="01">Jan (01)</option>
                                            <option value="02">Feb (02)</option>
                                            <option value="03">Mar (03)</option>
                                            <option value="04">Apr (04)</option>
                                            <option value="05">May (05)</option>
                                            <option value="06">June (06)</option>
                                            <option value="07">July (07)</option>
                                            <option value="08">Aug (08)</option>
                                            <option value="09">Sep (09)</option>
                                            <option value="10">Oct (10)</option>
                                            <option value="11">Nov (11)</option>
                                            <option value="12">Dec (12)</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4">
                                        <select class="form-control" name="expire-year">
                                            <option>Year</option>
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-cvv">Card CVV</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="input-cvv" name="EWAY_CARDCVN" data-eway-encrypt-name="EWAY_CARDCVN">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="select-type">Card Type</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="select-type" name="type">
                                    <option value="">---</option>
                                    <option value="visa">Visa</option>
                                    <option value="mastercard">Mastercard</option>
                                    <option value="amex">Amex</option>
                                    <option value="discover">Discover</option>
                                    <option value="maestro">Maestro</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save card</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Pyramd Tips</h4>

                </div>
            </div>
        </div>
        <!-- end row -->

    </div>

@endsection

@section('scripts')
    <script src="https://secure.ewaypayments.com/scripts/eCrypt.min.js"></script>
@endsection