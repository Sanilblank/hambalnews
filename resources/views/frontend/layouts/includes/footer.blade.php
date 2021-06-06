<!-- Footer Start-->
<div class="footer-area footer-padding fix">
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="single-footer-caption">
                    <div class="single-footer-caption">
                        <!-- logo -->
                        <div class="footer-logo">
                            <a href="{{route('index')}}"><img src="{{Storage::disk('uploads')->url($setting->siteImage)}}" alt="{{$setting->sitename}}" style="max-height: 200px; width:auto"></a>
                        </div>
                        <div class="footer-tittle">
                            <div class="footer-pera">
                                <h1 style="color: white">{{$setting->sitename}}</h1>
                            </div>
                        </div>
                        <!-- social -->
                        <div class="footer-social mt-2">
                            <p style="color: white;">हामीलाई पछ्याउनुहोस: &nbsp;&nbsp;
                               <a href="{{$setting->facebook}}" target="_blank"><i class="fab fa-facebook" style="color: white"></i></a>
                               <a href="{{$setting->instagram}}" target="_blank"><i class="fab fa-instagram" style="color: white"></i></a>
                               <!--<a href="{{$setting->linkedin}}" target="_blank"><i class="fab fa-linkedin-in" style="color: white"></i></a>-->
                               <a href="{{$setting->youtube}}" target="_blank"><i class="fab fa-youtube" style="color: white"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6  col-sm-12 text-left">
                <div class="single-footer-caption mt-60">
                    <div class="footer-tittle">
                        <h4>न्यूजलेटर</h4>
                        <p>सदस्यता लिनुहोस्</p>
                        <!-- Form -->
                        <form action="{{route('register.subscriber')}}" method="GET">
                           @csrf
                           @method('GET')
                           <input type="email" name="email" class="form-control" placeholder="तपाइँको ईमेल" required>
                           @error('email')
                               <div class="text-danger">{{$message}}</div>
                           @enderror
                           <button type="submit" class="btn btn-success mt-4">बुझाउनुहोस्</button>
                       </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                <div class="single-footer-caption mb-50 mt-60">
                    <div class="footer-tittle">
                        <h4>हामीलाई भेटाउनुहोस्</h4>
                    </div>
                    <div class="instagram-gellay">
                        <ul>
                            <li style="color: white"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;{{$setting->address}}</li><br>
                            <li style="color: white"><i class="fa fa-phone"></i> &nbsp;&nbsp;{{$setting->phone}}</li><br>
                            <li style="color: white"><i class="fa fa-envelope"></i> &nbsp;&nbsp;{{$setting->email}}</li><br>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer-bottom aera -->
<div class="footer-bottom-area">
   <div class="container">
       <div class="footer-border">
            <div class="row d-flex align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="footer-copy-right">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                           प्रतिलिपि अधिकार &copy;<script>document.write(new Date().getFullYear());</script> | <a href="https://news.revonepal.com/" target="_blank">{{$setting->sitename}}</a>
                           <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer-menu f-right">
                        <ul>
                            <li><a href="{{route('aboutus')}}">हाम्रोबारे</a></li>
                            <li><a href="#">प्रयोगका सर्तहरू</a></li>
                            <li><a href="{{route('privacypolicy')}}">गोपनीयता नीति</a></li>
                            <!--<li><a href="#">Contact</a></li>-->
                        </ul>
                    </div>
                </div>
            </div>
       </div>
   </div>
</div>
<!-- Footer End-->
