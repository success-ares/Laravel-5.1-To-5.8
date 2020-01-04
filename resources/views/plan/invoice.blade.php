@extends('layout')

@section('title', 'Invoice')

@inject('carbon', 'Carbon\Carbon')

@section('content')

    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title">Invoice</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="clearfix">
                            <div class="pull-left">
                                <h3 class="logo invoice-logo">Pyramd</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="pull-left m-t-30">
                                    <address>
                                        <strong>Pyramd Ltd.</strong><br>
                                        84B Hurstmere Rd<br>
                                        Takapuna, Auckland 0622<br>
					New Zealand
                                        <abbr title="Phone">P:</abbr> +64 (09) 280 3470
                                    </address>
                                </div>
                                <div class="pull-right m-t-30">
                                    <p><strong>Order Date: </strong> {{ $carbon->now()->toFormattedDateString() }}</p>
                                    <p class="m-t-10"><strong>Order Status: </strong> <span class="label label-info">Pending</span></p>
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="m-h-50"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table m-t-30">
                                        <thead>
                                        <tr><th>#</th>
                                            <th>Item</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Cost</th>
                                            <th>Total</th>
                                        </tr></thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Business Plan</td>
                                            <td>Monthly plan with unlimited sales accounts.</td>
                                            <td>1</td>
                                            <td>NZ$ 9.99</td>
                                            <td>NZ$ 9.99</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="clearfix m-t-40">
                                    <?php /*<h5 class="small text-inverse font-600">PAYMENT TERMS AND POLICIES</h5>

                                    <small>
                                        
                                        invoice. To be paid by cheque or credit card or direct payment
                                        online. If account is not paid within 7 days the credits details
                                        supplied as confirmation of work undertaken will be charged the
                                        agreed quoted fee noted above.
                                    </small>*/ ?>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-6 col-md-offset-3">
                                <p class="text-right"><b>Total:</b> NZ$ 9.99</p>
                                <hr>
                                <h3 class="text-right">NZ$ 9.99</h3>
                            </div>
                        </div>
                        <hr>
                        <div class="hidden-print">
                            <div class="pull-right">
                                <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light"><i class="fa fa-print"></i></a>
                                <a href="{{ route('site.plan.create') }}" class="btn btn-primary waves-effect waves-light">Pay</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
