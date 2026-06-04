<!DOCTYPE html>
<html>

<head>

<title>Struk</title>

<style>

@page{
    size:58mm auto;
    margin:0;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html,
body{
    width:58mm;
    margin:0;
    padding:0;
}

body{
    font-family:monospace;
    font-size:11px;

    position:absolute;
    top:0;
    left:0;
}

.wrapper{
    width:54mm;
    padding:2mm;
}

.center{
    text-align:center;
}

.line{
    border-top:1px dashed black;
    margin:3px 0;
}

.row{
    display:flex;
    justify-content:space-between;
}

.item{
    margin-bottom:4px;
}

</style>

</head>

<body>

<div style="margin-top:0;padding-top:0;">

<div class="wrapper">

    <div class="center">

        <b>WARUNG MAK KAJI</b><br>

        Kasir :
        {{ auth()->user()->name ?? 'Admin' }}

        <br>

        {{ now()->format('d-m-Y H:i') }}

    </div>


    <div class="line"></div>


    @foreach($items as $item)

    <div class="item">

        <div>

            {{ $item->product->nama_barang }}

        </div>

        <div class="row">

            <span>

                {{ $item->qty }}
                x
                {{ number_format($item->product->harga) }}

            </span>

            <span>

                {{ number_format($item->subtotal) }}

            </span>

        </div>

    </div>

    @endforeach


    <div class="line"></div>


    <div class="row">

        <span>Total</span>

        <span>

            Rp {{ number_format($transaction->total) }}

        </span>

    </div>


    <div class="row">

        <span>Bayar</span>

        <span>

            Rp {{ number_format($transaction->bayar) }}

        </span>

    </div>


    <div class="row">

        <span>Kembali</span>

        <span>

            Rp {{ number_format($transaction->kembalian) }}

        </span>

    </div>


    <div class="line"></div>


    <div class="center">

        Terima kasih 🙏

    </div>

</div>

</div>


<script>

window.onload=function(){

    setTimeout(()=>{

        window.print();

    },300);

}

</script>

</body>

</html>