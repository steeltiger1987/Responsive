@extends('pdf.pdf')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
    		<div class="invoice-title">
    			<h3 class="pull-right">Faktura # {{ $id }}</h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-3">
    				<address>
    				<strong>DODAVATEL:</strong><br>
    					Teleportuj Europe s.r.o<br>
    					Devonska 1223/7<br>
    					15200 Praha<br>
    					Česka republika<br><br><br>

    					IČ:04694171<br><br>

    					Okr.sud Mestsky soud v Praze, Vl. č. C 252222
    				</address>
    			</div>
    			<div class="col-xs-3">
                    <img src="images/teleportoo-logo.jpg">
                </div>
    			<div class="col-xs-3 text-right">
    				<address>
        			<strong>ODBRERATEL:</strong><br>
    					{{ $company_name }}<br>
    					{{ $address }}<br>
    					{{ $city }}<br>
    					{{ $country }}
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-5">
    				<address>
    					Banka: 164540273/0600 <br>
                        Variabilní symbol: {{ $variable }} <br>
                        Konstantní symbol: 0308 <br>
                        Způsob platby: Bankovním převodem <br>
    				</address>
    			</div>
    			<div class="col-xs-5 text-right">
    				<address>
    					<span class="pull-left">IČ: {{ $business_id }}</span> <span class="pull-right">Datum vystavení: {{ $date_top_up }}</span><br>
                        <span class="pull-left">DIČ:{{ $tax_id }} - if filled out</span> <span class="pull-right">Zdanitelné plnění: {{ $date_top_up }}</span> <br>
                        <span class="pull-right">Datum splatnosti: {{ $date_top_up }}</span>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-xs-6">
    		Název položky a popis
    	</div>
    	<div class="col-xs-3">
            Cena položky
    	</div>
    	<div class="col-xs-3">
            Celkem
    	</div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-6">
            Debiti Kreditu/Topup<br>
            Teleportoo topup.
        </div>
        <div class="col-xs-3">
            {{ $amount }} {{ $currency }}
        </div>
        <div class="col-xs-3">
            {{ $amount }} {{ $currency }}
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-5">
            Pozamka:
        </div>
        <div class="col-xs-5">
            <div class="row">
                <div class="col-xs-5">
                    Celkam: <br>
                    Částka zaplacena:
                    Částka k zaplacení:
                </div>
                <div class="col-xs-4">
                    {{ $amount }} {{ $currency }}
                    {{ $amount }} {{ $currency }}
                    0.00 {{ $currency }}
                </div>
            </div>
            <hr>
            <div class="row">
                Podpis a razítko: signature image
            </div>
        </div>

    </div>
</div>
@endsection