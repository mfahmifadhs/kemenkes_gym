@extends('app')
@section('content')

<!-- Contact Section Begin -->
<section class="contact-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto mt-5">
                <div class="section-title contact-title text-center">
                    <h2><u>SURVEY KEPUASAN</u></h2>
                </div>
                <div class="leave-comment">
                    <form id="form" action="{{ route('survey.post', $id) }}" method="POST">
                        @csrf
                        <table>
                            <tr>
                                <td>
                                    <label class="btn mx-auto my-1 p-2">
                                        <input name="result" type="checkbox" class="survey-checkbox" value="puas">
                                        <img src="{{ asset('dist/img/survey/happy.png') }}" class="w-50 face-img" id="happy-img">
                                    </label>
                                </td>
                                <td>
                                    <label class="btn mx-auto my-1 p-2">
                                        <input name="result" type="checkbox" class="survey-checkbox" value="tidak puas">
                                        <img src="{{ asset('dist/img/survey/sad.png') }}" class="w-50 face-img" id="sad-img">
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">
                                    <center>
                                        <textarea name="masukan" class="form-control bg-white text-black w-75" cols="5" rows="2" placeholder="Kritik dan masukan"></textarea>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <center>
                                        <button type="submit" class="btn btn-primary w-75" onclick="confirmSubmit(event)">Submit</button>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

@section('js')

<script>
    function confirmSubmit(event) {
        event.preventDefault();
        const form = document.getElementById('form');

        const checkboxes = document.querySelectorAll('input[name="result"]');
        let isChecked = false;

        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                isChecked = true;
            }
        });

        if (!isChecked) {
            Swal.fire({
                title: 'Error!',
                text: 'Pilih salah satu kepuasan',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false; // Prevent form submission
        } else {
            // Show loading popup
            Swal.fire({
                title: "Proses...",
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                willOpen: () => {
                    Swal.showLoading();
                },
            });

            form.submit();
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dapatkan semua elemen gambar dengan kelas face-img
        var faceImages = document.querySelectorAll('.face-img');

        // Fungsi untuk mengubah warna gambar
        function toggleFaces(clickedImg) {
            faceImages.forEach(function(img) {
                if (img === clickedImg) {
                    // Gambar yang diklik menjadi merah
                    img.classList.add('red-face');
                } else {
                    // Gambar lainnya menjadi kuning
                    img.classList.remove('red-face');
                }
            });
        }

        // Tambahkan event listener untuk setiap gambar
        faceImages.forEach(function(img) {
            img.addEventListener('click', function() {
                toggleFaces(img);
            });
        });
    });
</script>
@endsection

@endsection
