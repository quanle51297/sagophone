@extends('admin.layout.index')
@section('content')
<section id="basic-form-layouts">
	<div class="row">
        <div class="col-sm-12">
            <div class="content-header">loaitin</div>
        </div>
    </div>
	
		


<!--form them-->
	<div class="row match-height">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="basic-layout-tooltip">Sửa</h4>
					<p class="mb-12"></p>
					<a href="admin/loaitin/danhsach" ><span class="badge badge-success mr-2"><i class="ft-corner-down-left"></i> Danh sách</span></a>
				</div>
				<div class="card-body">
					<div class="px-3">
						@if(count($errors)>0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    {{ $err }}<br>
                                @endforeach
                            </div>
                        @endif

                        @if(session('thongbao'))
                            <div class="alert alert-success">
                                {{ session('thongbao') }}
                            </div>
                        @endif
						<form class="form" action="admin/loaitin/sua/{{ $loaitin->id }}" method="POST">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="form-body">
								<div class="form-body">
								<div class="form-group">
									<label for="issueinput1">Tên chức vụ</label>
									<input type="text" id="issueinput1" class="form-control"  name="txtTen" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Issue Title" value="{{ $loaitin->tenloaitin }}" placeholder="Vui lòng nhập tên chức vụ">
								</div>
							</div>
							<div class="form-group">
									<label for="issueinput5">Trạng thái</label>
									<select id="issueinput5" name="txtTrangthai" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority" >
										<option @if($loaitin->trangthai =='show') selected="" @endif value="show">HIỆN</option>
										<option @if($loaitin->trangthai =='hide') selected="" @endif  value="hide">ẨN</option>
									</select>
							</div>
							<div class="form-actions">
								<button type="reset" class="btn btn-raised btn-warning mr-1">
									<i class="ft-refresh-ccw"></i> Làm mới
								</button>							
								<button type="submit" class="btn btn-raised btn-primary">
									<i class="fa fa-check-square-o"></i> Sửa
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		
<!--form them end-->
@endsection