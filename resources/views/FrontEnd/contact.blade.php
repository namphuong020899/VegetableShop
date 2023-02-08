@extends('Layout_user')
@section('title', 'Contact us')
@section('content')
    @include('FrontEnd.Sample.banner_sample')
    <section class="ftco-section contact-section bg-light">
        <div class="container">
            <div class="row d-flex mb-5 contact-info">
                <div class="w-100"></div>
                <div class="col-md-3 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Address:</span> 198/789 Quận 1xxx</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Phone:</span> <a href="tel:1235 2355 98">+ 1235 2355 98</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Email:</span> <a href="mailto:pipj.contact@gmail.com">your@gmail.com</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="info bg-white p-4">
                        <p><span>Website</span> <a href="#">yoursite.com</a></p>
                    </div>
                </div>
            </div>
            <div id="checkdis" class="alert alert-success alert-dismissible fade hide" role="alert">
                <strong>Successfully!</strong> <span id="nonfi"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row block-9">
                <div class="col-md-6 order-md-last d-flex">
                    <form id="submitform_contact" class="bg-white p-5 contact-form">
                        <div class="form-group">
                            <input type="text" required id="contact_name" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <input type="email" required id="contact_email" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="form-group">
                            <input type="text" readonly id="contact_subject" class="form-control" placeholder="Subject"
                                value="Contact Us">
                        </div>
                        <div class="form-group">
                            <textarea required name="contact_message" id="contact_message" cols="30" rows="7"
                                class="form-control" placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5 submit">
                        </div>
                    </form>

                </div>

                <div class="col-md-6 d-flex">
                    <div class="bg-white">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d501000.4874080593!2d106.37079345487204!3d11.18272642219485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174b66a8ef92879%3A0x339fda891c8d1473!2zQsOsbmggRMawxqFuZywgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1638172557402!5m2!1svi!2s"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="http://parsleyjs.org/dist/parsley.js"></script>
    <script>
        $(document).ready(function() {
            $('#submitform_contact').parsley();
            $(document).on('submit', '#submitform_contact', function(e) {
                e.preventDefault();
                var name = $('#contact_name').val();
                var email = $('#contact_email').val();
                var subject = $('#contact_subject').val();
                var mess = $('#contact_message').val();

                if ($('#submitform_contact').parsley().isValid()) {
                    $.ajax({
                        type: 'post',
                        url: '{{ route('contact.store') }}',
                        data: {
                            name: name,
                            email: email,
                            subject: subject,
                            mess: mess
                        },
                        dataType: 'json',
                        beforeSend:function(){
                            $('.submit').attr('disabled','disabled');
                            $('.submit').val('Sending...');
                        },
                        success: function(res) {
                            $('.submit').attr('disabled',false);
                            $('.submit').val('Send Message');
                            $('#checkdis').removeClass('hide');
                            $('#checkdis').addClass('show');
                            $('#nonfi').text(res.message);
                            $('#submitform_contact')[0].reset();
                        }
                    });
                }
            });
        });
    </script>
@endsection
