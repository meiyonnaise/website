<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    
</head>

<!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chatModal">
    Open Chat
</button>

<!-- The Modal -->
<div class="modal" id="chatModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <section style="background-color: light;">
                    <div class="container py-5">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-14 col-lg-14 col-xl-14">
                                
                                <div class="card" id="chat1" style="border-radius: 15px;">
                                    <div class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                                        <i class="fas fa-angle-left"></i>
                                        <p class="mb-0 fw-bold">Chat Room</p>
                                        <i class="fas fa-times"></i>  
                                        <!-- can delete the icons -->
                                    </div>

                                    <div class="card-body">
                                        <div class="d-flex flex-row justify-content-start mb-4">
                                            <!-- change the image to be the user's icons. -->
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                                <p class="small mb-0" id="otherUser">Hello and thank you for visiting MDBootstrap. Please click the video
                                                    below.</p>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row justify-content-end mb-4">
                                            <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                                                <p class="small mb-0" id="currentUser">Thank you, I really like your product.</p>
                                            </div>
                                            
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                                        </div>

                                        <div class="d-flex flex-row justify-content-start mb-4">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                                            <div class="ms-3" style="border-radius: 15px;">
                                                <div class="bg-image">
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/screenshot1.webp" style="border-radius: 15px;" alt="video">
                                                    <a href="#!">
                                                        <div class="mask"></div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row justify-content-start mb-4">
                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1" style="width: 45px; height: 100%;">
                                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                                <p class="small mb-0">...</p>
                                            </div>
                                        </div>

                                        <div class="form-outline">
                                            <textarea class="form-control" id="inputMessage" rows="4"></textarea>
                                            <label class="form-label" for="textAreaExample">Type your message</label>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </section>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

