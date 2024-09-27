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
        <form class="form-inline" method="GET" action="{{route('hasil')}}">
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
            Waktu buka ujian &nbsp; &nbsp; &nbsp;: {{date("d-m-Y H:i:s", $quiz->timeopen)}}
            <br/>Waktu tutup ujian  &nbsp; &nbsp; : {{date("d-m-Y H:i:s",$quiz->timeclose)}}
            <br/>Durasi ujian  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: 
            @php
            $durasi = $quiz->timelimit/60;
            echo $durasi;
            @endphp
            menit
            <br/></strong>
            <!-- Jumlah peserta ujian : {{$jumlahPeserta}} orang</strong><br/> -->
            <a href="{{route('export',$quiz->id)}}" class="btn btn-md btn-primary"> <strong>Download Hasil</strong></a><br/>
            <table class="table table-bordered table-hover table-responsive-lg">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kelas</th>
                        <th>Nama</th>
                        <th>Hasil Ujian</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($data as $data)
                    <tr>
                        <th scope="row">{{$i}}</th>
                        <td>{{$data->lastname}}</td>
                        <td>{{$data->firstname}}</td>
                        <td>
                            @php

                            if($data->grade >= 75){
                                $btn2 = "btn-success";
                                $kategori = "A";
                            }elseif($data->grade >= 50){
                                $btn2 = "btn-warning";
                                $kategori = "B";
                            }elseif($data->grade >= 25){
                                $btn2 = "btn-danger";
                                $kategori = "C";
                            }elseif($data->grade >= 0){
                                $btn2 = "btn-dark";
                                $kategori = "D";
                            }
                            @endphp
                            <button class="btn btn-sm {{$btn2}}"> <strong>  {{round($data->grade)}}</strong></button>
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