<div>
   @livewire('admin.breadcrumb',['page' => $page])
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-3" wire:ignore.self>
               <!-- Profile Image -->
               <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                     <div class="text-center">
                        <label id="profile_img">
                           @php $imgurl = (isset($image) && $image != null) ? $image->temporaryUrl() : $userimage; @endphp
                           <div class="profile-pic profile-user-img img-circle" style="height: 150px; width: 150px; background-size: cover; background-repeat: no-repeat; background-image: url({{$imgurl}})">
                              <label for="fileToUpload"><i class="fa fa-pencil"></i></label>
                           </div>
                        </label>
                        <input type="File" wire:model="image" id="fileToUpload">
                        @error('image') <span class="error text-danger">{{ $message }}</span> @enderror
                     </div>
                     <h3 class="profile-username text-center">{{$email ?? '-'}}</h3>
                     <!-- <p class="text-muted text-center">Software Engineer</p> -->
                     <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                           <b>Followers</b> <a class="float-right">-</a>
                        </li>
                        <li class="list-group-item">
                           <b>Following</b> <a class="float-right">-</a>
                        </li>
                        <li class="list-group-item">
                           <b>Friends</b> <a class="float-right">-</a>
                        </li>
                     </ul>
                     <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                  </div>
                  <!-- /.card-body -->
               </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9" wire:ignore.self>
               <div class="card">
                  <div class="card-header p-2">
                     <ul class="nav nav-pills">
                        <li class="nav-item"><a wire:click="setTab('profile')" class="nav-link {{$activeTab == 'profile' ? 'active':'' }}" href="#profile" data-toggle="tab">Profile</a></li>
                        <li class="nav-item"><a wire:click="setTab('password')" class="nav-link {{$activeTab == 'password' ? 'active':'' }}" href="#password" data-toggle="tab">Password</a></li>
                        <li class="nav-item"><a wire:click="setTab('settings')" class="nav-link {{$activeTab == 'settings' ? 'active':'' }}" href="#settings" data-toggle="tab">Settings</a></li>
                     </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                     <div class="tab-content">
                        <div class="tab-pane {{$activeTab == 'profile' ? 'active':'' }}" id="profile">
                           <form wire:submit.prevent="submit" class="form-horizontal">
                              <div>
                                 <div class="clearfix">
                                    <div class="form-group row">
                                       <label for="first_name" class="col-sm-2 col-form-label">First Name <span class="text-danger">*</span></label>
                                       <div class="col-sm-10">
                                          <input type="text" wire:model.lazy="first_name" class="form-control" id="first_name" placeholder="First Name">
                                          @error('first_name') <span class="error text-danger">{{ $message }}</span> @enderror
                                       </div>
                                    </div>

                                    <div class="form-group row">
                                       <label for="last_name" class="col-sm-2 col-form-label">Last Name <span class="text-danger">*</span></label>
                                       <div class="col-sm-10">
                                          <input type="text" wire:model.lazy="last_name" class="form-control" id="last_name" placeholder="Last Name">
                                          @error('last_name') <span class="error text-danger">{{ $message }}</span> @enderror
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="text-right">
                                 <button type="submit" class="btn btn-primary">Update Profile</button>
                              </div>
                           </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane {{$activeTab == 'password' ? 'active':'' }}" id="password">
                           <form wire:submit.prevent="updatePassword" class="form-horizontal">
                              <div>
                                 <div class="">
                                    <div class="form-group row">
                                       <label for="old_password" class="col-sm-3 col-form-label">Old Password <span class="text-danger">*</span></label>
                                       <div class="col-sm-9">
                                          <input type="password" wire:model.lazy="old_password" class="form-control" id="old_password" placeholder="Old Password">
                                          @error('old_password') <span class="error text-danger">{{ $message }}</span> @enderror
                                       </div>
                                    </div>
                                    <div class="form-group row">
                                       <label for="password" class="col-sm-3 col-form-label">New Password <span class="text-danger">*</span></label>
                                       <div class="col-sm-9">
                                          <input type="password" wire:model.lazy="password" class="form-control" id="password" placeholder="New Password">
                                          @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
                                       </div>
                                    </div>

                                    <div class="form-group row">
                                       <label for="password_confirmation" class="col-sm-3 col-form-label">Confirm Password <span class="text-danger">*</span></label>
                                       <div class="col-sm-9">
                                          <input type="password" wire:model.lazy="password_confirmation" class="form-control" id="password_confirmation" placeholder="Password confirmation">
                                          @error('password_confirmation') <span class="error text-danger">{{ $message }}</span> @enderror
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="text-right">
                                 <button type="submit" class="btn btn-primary">Update</button>
                              </div>
                           </form>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane {{$activeTab == 'settings' ? 'active':'' }}" id="settings">
                           <form wire:submit.prevent="saveSetting" class="form-horizontal">
                              <div class="">
                                 <div class="form-group row">
                                    <label for="support_email" class="col-sm-3 col-form-label">Support Email <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                       <input type="email" wire:model.lazy="support_email" class="form-control" id="support_email" placeholder="Support Email">
                                       @error('support_email') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="contact" class="col-sm-3 col-form-label">Contact <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                       <input type="number" wire:model.lazy="contact" class="form-control" id="contact" placeholder="Contact">
                                       @error('contact') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <label for="address" class="col-sm-3 col-form-label">Address <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                       <input type="text" wire:model.lazy="address" class="form-control" id="address" placeholder="Address">
                                       @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <div class="col-md-6">
                                       <label><b>Logo image</b></label>
                                       <div class="custom-file">
                                          <input wire:model.lazy="logo_image" type="file" class="form-control custom-file-input" id="customFile1">
                                          <label class="custom-file-label" for="customFile1">Choose file</label>
                                       </div>
                                       @error('logo_image') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 pt-2">
                                       @if ($logo_image)
                                       <img class="preview_image w-25 ml-2" id="preview_image" src="{{ $logo_image->temporaryUrl() }}">
                                       @elseif($logo_image_url != '')
                                       <img class="preview_image w-25 ml-2" src="{{ $logo_image_url }}">
                                       @endif
                                    </div>
                                 </div>
                                 <div class="form-group row">
                                    <div class="col-12">
                                       <b>Social Handles</b>
                                    </div>
                                    <div class="col-12">
                                       <div class="row m-2 p-3">
                                          <div class="col-md-6 col-sm-12">
                                             <div class="form-group">
                                                <label>Facebook</label>
                                                <input type="text" wire:model.lazy="facebook" type="text" placeholder="Facebook" class="form-control">
                                                @error('facebook') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                                             </div>
                                          </div>
                                          <div class="col-md-6 col-sm-12">
                                             <div class="form-group">
                                                <label>Twitter</label>
                                                <input type="text" wire:model.lazy="twitter" type="text" placeholder="Twitter" class="form-control">
                                                @error('twitter') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                                             </div>
                                          </div>
                                          <div class="col-md-6 col-sm-12">
                                             <div class="form-group">
                                                <label>LinkedIN</label>
                                                <input type="text" wire:model.lazy="linkedin" type="text" placeholder="LinkedIN" class="form-control">
                                                @error('linkedin') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                                             </div>
                                          </div>
                                          <div class="col-md-6 col-sm-12">
                                             <div class="form-group">
                                                <label>Instagram</label>
                                                <input type="text" wire:model.lazy="instagram" type="text" placeholder="Instagram" class="form-control">
                                                @error('instagram') <span class="error text-danger err_margin">{{ $message }}</span> @enderror
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="text-right">
                                 <button type="submit" class="btn btn-primary">Submit</button>
                              </div>
                           </form>
                        </div>
                        <!-- /.tab-pane -->
                     </div>
                     <!-- /.tab-content -->
                  </div><!-- /.card-body -->
               </div>
               <!-- /.card -->
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div><!-- /.container-fluid -->
   </section>
</div>