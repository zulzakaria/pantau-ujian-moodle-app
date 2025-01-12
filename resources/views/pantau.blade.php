@extends('layouts.layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <button class="form-control btn btn-sm btn-warning"> <strong>
            @php
            
                echo "Hari ini : " . date("d-m-Y") . " Pukul : " . date("H:i:s");
                
                $i=1;
            @endphp
            </strong>
            </button>
        </div>
        <div class="col-md-12"><br></div>
        <div class="col-md-12">
        <form class="form-inline" method="GET" action="{{route('pantau')}}">
            <div class="form-group">
            Mata Pelajaran : &nbsp;
                <select name="course" id="" class="form-control">
                    @foreach ($course as $course)
                        <option value="{{$course->id}}" {{ $select == $course->id ? "selected" : "" }}>{{$course->fullname}}</option>
                    @endforeach    
                </select>
            </div>
            &nbsp;<input type="submit" class="btn btn-md btn-primary" value="Tampilkan">
        </form>
        </div>
        <div class="col-md-12"><hr/></div>
        @if ($quiz != null)
        <div class="col-md-12">
            <strong>
            Kode Mapel &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: {{$quiz->name}}<br/>    
            Waktu buka ujian &nbsp; &nbsp; &nbsp;: {{date("d-m-Y H:i:s", $quiz->timeopen)}}
            <br/>Waktu tutup ujian  &nbsp; &nbsp; : {{date("d-m-Y H:i:s",$quiz->timeclose)}}
            <br/>Durasi ujian  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: 
            @php
            $durasi = $quiz->timelimit/60;
            echo $durasi;
            @endphp
            menit
            <br/>Jumlah peserta ujian : {{$jumlahPeserta}} orang </strong>
            <hr/>
            Kategori rentang nilai hasil ujian : <br/><strong> A (75-100) | B (50-74) | C (25-49) | D (0-24)</strong>
            <table class="table table-bordered table-hover table-responsive-lg">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kelas</th>
                        <th>Nama</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Durasi Mengerjakan</th>
                        <th>Status Ujian</th>
                        <th>Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($attempts as $attempt)
                    <tr>
                        <th scope="row">{{$i}}</th>
                        <td>{{$attempt->lastname}}</td>
                        <td>{{$attempt->firstname}}</td>
                        <td>{{date("H:i:s",$attempt->timestart)}}</td>
                        <td>{{$attempt->timefinish == 0 ? "-" : date("H:i:s",$attempt->timefinish)}}</td>
                        <td>{{$attempt->timefinish == 0 ? "-" : round(($attempt->timefinish-$attempt->timestart)/60)}} menit</td>
                        @php
                            if($attempt->state == "finished"){
                                $btn = "btn-primary";
                                $status = "Selesai";
                            }else{
                                $btn = "btn-secondary";
                                $status = "Sementara Ujian";
                            }
                        @endphp
                        <td>
                            <button class="btn btn-sm {{$btn}}"> <strong>{{$status}}</strong></button>
                        </td>
                        <td>
                            @php
                            if($attempt->state == "finished"){
                            $nilai = $attempt->benar / $attempt->jumSoal * 100;
                                if($nilai >= 75){
                                    $btn2 = "btn-success";
                                    $kategori = "A";
                                }elseif($nilai >= 50){
                                    $btn2 = "btn-warning";
                                    $kategori = "B";
                                }elseif($nilai >= 25){
                                    $btn2 = "btn-danger";
                                    $kategori = "C";
                                }elseif($nilai >= 0){
                                    $btn2 = "btn-dark";
                                    $kategori = "D";
                                }
                            }else{
                                $btn2 = "btn-default";
                                $kategori = "-";
                            }
                            @endphp
                            <button class="btn btn-sm {{$btn2}}"> <strong>Kategori : {{$kategori}}</strong></button>
                        </td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach   
                </tbody>
            </table>  
        </div>
        @else
        <div class="col-md-12"><strong>Ujian belum terjadwal.</strong></div> 
        @endif

    </div> 
</div>

@endsection