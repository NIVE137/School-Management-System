@extends('Admin.layout')
@section('content')
@php
$documents = [
    'birth_certificate' => 'Birth Certificate',
    'aadher'            => 'Aadhaar Card',
    'parent_idproof'    => 'Parent ID Proof',
    'address_proof'     => 'Address Proof',
    'tc'                => 'Transfer Certificate',
    'mark_sheet'        => 'Mark Sheet',
];
@endphp
<style>
.page-back{display:flex;align-items:center;gap:14px;margin-bottom:22px;}
.btn-back{background:#fff;border:1.5px solid #e7e7ff;border-radius:8px;width:38px;height:38px;display:flex;align-items:center;justify-content:center;color:#566a7f;text-decoration:none;transition:all .2s;}
.btn-back:hover{background:#696cff;border-color:#696cff;color:#fff;}
.custom-card{background:#fff;border-radius:12px;border:1px solid rgba(231,231,255,0.8);box-shadow:0 2px 20px rgba(105,108,255,0.08);padding:24px;margin-bottom:24px;}
.image-upload{border:2px dashed #d9dee3;border-radius:10px;background:#f8f8ff;min-height:200px;padding:14px;display:flex;flex-direction:column;justify-content:center;align-items:center;overflow:hidden;transition:.2s;}
.image-upload:hover{border-color:#696cff;background:rgba(105,108,255,0.03);}
.image-upload i{font-size:24px;margin-bottom:8px;color:#a5b7c8;}
.document-image{width:100%;height:160px;object-fit:cover;border-radius:8px;display:block;}
.doc-label{font-size:0.78rem;font-weight:600;color:#566a7f;text-align:center;margin-top:8px;}
.btn-cyan{background:linear-gradient(135deg,#696cff,#03c3ec);color:#fff;border:none;font-weight:600;padding:10px 22px;border-radius:8px;font-size:0.875rem;transition:all .2s;cursor:pointer;}
.btn-cyan:hover{box-shadow:0 6px 20px rgba(105,108,255,0.38);transform:translateY(-1px);color:#fff;}
</style>

<div class="page-back">
    <a href="javascript:history.back()" class="btn-back"><i class="fa-solid fa-angle-left"></i></a>
    <div>
        <h4 class="fw-bold mb-0" style="color:#32475c;">Upload Documents</h4>
        <small class="text-muted">{{ $student->student_name }} — Student Documents</small>
    </div>
</div>

<div class="custom-card">
    <form action="{{ route('savedocuments', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#a5b7c8;margin-bottom:18px;padding-bottom:8px;border-bottom:2px solid #e7e7ff;">Student & Parent Identification</div>
        <div class="row g-4">
            @foreach($documents as $field => $title)
            <div class="col-md-4">
                <div class="doc-label mb-2" style="font-size:0.82rem;font-weight:600;color:#566a7f;">{{ $title }}</div>
                <div class="image-upload">
                    @if($student->$field)
                        @php $ext = strtolower(pathinfo($student->$field, PATHINFO_EXTENSION)); @endphp
                        @if(in_array($ext,['jpg','jpeg','png']))
                            <img id="preview_{{ $field }}" src="{{ asset('asset/documents/'.$student->$field) }}" class="document-image">
                            <div id="pdf_{{ $field }}" style="display:none;text-align:center;"><i class="fas fa-file-pdf text-danger" style="font-size:60px;"></i><p id="pdfname_{{ $field }}" class="mt-2" style="font-size:0.8rem;"></p></div>
                        @else
                            <img id="preview_{{ $field }}" class="document-image" style="display:none;">
                            <div id="pdf_{{ $field }}" style="text-align:center;"><i class="fas fa-file-pdf text-danger" style="font-size:60px;"></i><p id="pdfname_{{ $field }}" class="mt-2" style="font-size:0.8rem;">{{ $student->$field }}</p></div>
                        @endif
                    @else
                        <img id="preview_{{ $field }}" class="document-image" style="display:none;">
                        <div id="pdf_{{ $field }}" style="display:none;text-align:center;"><i class="fas fa-file-pdf text-danger" style="font-size:60px;"></i><p id="pdfname_{{ $field }}" class="mt-2" style="font-size:0.8rem;"></p></div>
                        <i class="fas fa-cloud-upload-alt" style="font-size:28px;color:#a5b7c8;"></i>
                        <small style="font-size:0.75rem;color:#a5b7c8;margin-top:6px;">No file uploaded</small>
                    @endif
                    <div class="mt-3 d-flex gap-2">
                        <label class="btn btn-warning btn-sm" style="font-size:0.76rem;cursor:pointer;">
                            <i class="fas fa-edit me-1"></i>Edit
                            <input type="file" name="{{ $field }}" hidden accept=".jpg,.jpeg,.png,.pdf" onchange="previewFile(this,'{{ $field }}')">
                        </label>
                        <a href="/Admin/deletedocument/{{ $student->id }}/{{ $field }}" class="btn btn-danger btn-sm" style="font-size:0.76rem;"><i class="fas fa-trash me-1"></i>Delete</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if(isset($errors) && $errors->any())<div class="alert alert-danger mt-4"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <div class="mt-4 d-flex gap-3">
            <button type="submit" class="btn-cyan"><i class="fas fa-save me-1"></i> Save Documents</button>
            <button type="reset" class="btn btn-outline-secondary">Reset</button>
        </div>
    </form>
</div>

<script>
function previewFile(input,field){
    const file=input.files[0]; if(!file)return;
    const img=document.getElementById('preview_'+field),pdf=document.getElementById('pdf_'+field),pdfName=document.getElementById('pdfname_'+field);
    if(file.type.startsWith('image/')){
        const r=new FileReader();
        r.onload=function(e){img.src=e.target.result;img.style.display='block';pdf.style.display='none';};
        r.readAsDataURL(file);
    }else{img.style.display='none';pdf.style.display='block';pdfName.innerHTML=file.name;}
}
</script>
@endsection
