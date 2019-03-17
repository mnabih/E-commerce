@push('js')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script type="text/javascript">
Dropzone.autoDiscover = false;
$(document).ready(function(){
	$('#dropzoneDiv').dropzone({
		url:"{{ aurl('upload/image/' . $product->id ) }}",
		paramName:'file',
		uploadMultiple:false,
		maxFiles:15,
		maxFilessize:3, // MB
		dictDefaultMessage:'اضغط هنا لرفع الملفات او اسحبها وقم بافلاتها هنا',
		dictRemoveFile:"{{trans('admin.delete')}}",
		acceptedFiles:'image/*',
		params:{
			_token: "{{ csrf_token() }}"
		},
		addRemoveLinks:true,	
		removedfile:function(file)
		{
			//alert(file.fid)
			$.ajax({
				dataType:'json',
				type:'post',
				url: "{{ aurl('delete/image') }}",
				data:{_token:'{{ csrf_token() }}',id:file.fid }
			});
		var fmoke;
		return (fmoke = file.previewElement) != null? fmoke.parentNode.removeChild(file.previewElement): void 0;
		},

		init:function(){ // for display old imgs from database
			@foreach($product->files()->get() as $file)
				var moke = {name:'{{$file->name}}' ,fid:'{{$file->id}}', type: '{{$file->size}}', size: '{{$file->mime_type}}'};
				this.emit('addedfile',moke);
				this.options.thumbnail.call(this,moke,'{{url("storage/" . $file->full_file)}}');

			@endforeach

			this.on('sending',function(file,xhr,formData){
				formData.append('fid','');
				file.fid= '';
			});

			this.on('success',function(file,response){
				file.fid= response.id;
			});
		},
	});

	$('#mainPhoto').dropzone({
		url:"{{ aurl('update/image/' . $product->id ) }}",
		paramName:'file',
		uploadMultiple:false,
		maxFiles:1,
		maxFilessize:3, // MB
		dictDefaultMessage:'الصورة الرئيسية للمنتج',
		dictRemoveFile:"{{trans('admin.delete')}}",
		acceptedFiles:'image/*',
		params:{
			_token: "{{ csrf_token() }}"
		},
		addRemoveLinks:true,	
		removedfile:function(file)
		{
			//alert(file.fid)
			$.ajax({
				dataType:'json',
				type:'post',
				url: "{{ aurl('delete/product/image/' . $product->id) }}",
				data:{_token:'{{ csrf_token() }}'}
			});
		var fmoke;
		return (fmoke = file.previewElement) != null? fmoke.parentNode.removeChild(file.previewElement): void 0;
		},

		init:function(){ // for display old imgs from database

			@if(!empty($product->photo))
			var moke = {name:'{{$product->title}}' , type: '', size: ''};
			this.emit('addedfile',moke);
			this.options.thumbnail.call(this,moke,'{{url("storage/". $product->photo)}}');
			@endif

			this.on('sending',function(file,xhr,formData){
				formData.append('fid','');
				file.fid= '';
			});

			this.on('success',function(file,response){
				file.fid= response.id;
			});
		},
	});
});

</script>
<style type="text/css">
	.dz-progress{
		display: none;
	}
</style>
@endpush


<div id="product_media" class="tab-pane fade">
	<h3>{{trans('admin.product_media')}}</h3>

	<center><h4>{{trans('admin.mainPhoto')}}</h4></center>
	<div class="dropzone" id="mainPhoto"></div>

	<hr>
	<center><h4>{{trans('admin.Photos')}}</h4></center>
	<div class="dropzone" id="dropzoneDiv"></div>
</div>