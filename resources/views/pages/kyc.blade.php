@component('layouts.app')
    @if (!auth()->user()->kyc->verified && !auth()->user()->kyc->pending)
        <div class="main-container" x-data="init()">
            <form class="verify-gcaptcha mt-4" action="/verify" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container h-100 ">
                    <div class="row h-100">
                        <div class="col-12 align-self-center mb-4">
                            <div class="row justify-content-center">
                                <div class="col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                                    <h2 class="font-weight-normal mb-5 text-center text-primary"><b>Proof of residence</b>

                                        @if (auth()->user()->kyc->rejected)
                                            <div class=" text-red-600 text-xs">Your KYC verification details were rejected,
                                                please
                                                try
                                                again.</div>
                                        @endif

                                    </h2>
                                    <div class="flex flex-col gap-4">
                                        <div class="form-group float-label position-relative">
                                            <input class="form-control" id="name" name="name" type="test">
                                            <label class="form-control-label "><i class="las la-unlock-alt"></i>
                                                Full name(As in your identification document)</label>
                                            <x-input-error :messages="$errors->get('name')" class="text-start mt-2" />
                                        </div>
                                        {{-- <div class="form-group float-label active">
                                            <div class="input-group">
                                                <select class="form-control " id="country" name="country">
                                                    @foreach ($countries as $country)
                                                        <option class=" text-black" value="{{ $country->id }}">
                                                            {{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label class="form-control-label required" for="country"><i
                                                    class="las la-globe"></i> Country</label>

                                            <x-input-error :messages="$errors->get('country')" class="text-start mt-2" />
                                        </div> --}}

                                        <div class="form-group float-label position-relative">
                                            <input class="form-control " id="address" name="address" type="text">
                                            <label class="form-control-label "><i class="las la-unlock-alt"></i>
                                                Physical address</label>
                                            <x-input-error :messages="$errors->get('address')" class="text-start mt-2" />
                                        </div>

                                        <div class="form-group float-label active">
                                            <div class="input-group">
                                                <select class="form-control " id="document_type" name="document_type">
                                                    <option class=" text-black" value="voters card">National ID</option>
                                                    <option class=" text-black" value="voters card">Voters Card</option>
                                                    <option class=" text-black" value="voters card">Passport</option>
                                                </select>
                                            </div>
                                            <label class="form-control-label required" for="document_type"><i
                                                    class="las la-globe"></i> Document Type</label>
                                            <x-input-error :messages="$errors->get('document_type')" class="text-start mt-2" />
                                        </div>
                                        <div class="form-group float-label position-relative">
                                            <input class="form-control" id="name" name="document_number"
                                                type="text">
                                            <label class="form-control-label "><i class="las la-unlock-alt"></i>
                                                Document Number</label>
                                            <x-input-error :messages="$errors->get('document_number')" class="text-start mt-2" />
                                        </div>
                                        <div class=" ">
                                            <label for="">Document front view</label>
                                            <div class="flex items-center justify-center w-full">
                                                <label for="dropzone-file-1"
                                                    class="flex flex-col items-center justify-center w-full h-32 border-2 overflow-hidden border-gray-300 border-dashed rounded-lg cursor-pointer bg-transparent dark:hover:bg-bray-800 hover:bg-gray-100">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">

                                                        <img x-show="imagePreview1" :src="imagePreview1"
                                                            alt="Image Preview 1" class="w-full h-full mb-4">

                                                        <p x-show="!imagePreview1"
                                                            class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                                class="font-semibold">Click to upload</span> or drag and
                                                            drop
                                                        </p>
                                                        <p x-show="!imagePreview1"
                                                            class="text-xs text-gray-500 dark:text-gray-400">
                                                            SVG,
                                                            PNG, JPG or GIF (MAX.
                                                            800x400px)</p>
                                                    </div>
                                                    <input id="dropzone-file-1" name="document" type="file"
                                                        class="hidden" @change="previewImage(1, $event)">
                                                </label>
                                            </div>
                                            <x-input-error :messages="$errors->get('document')" class="text-start mt-2" />
                                        </div>
                                        <div class=" ">
                                            <label for="">A photo of you holding the document</label>
                                            <div class="flex items-center justify-center w-full">
                                                <label for="dropzone-file-3"
                                                    class="flex flex-col items-center justify-center w-full h-32 border-2 overflow-hidden border-gray-300 border-dashed rounded-lg cursor-pointer bg-transparent dark:hover:bg-bray-800 hover:bg-gray-100">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">

                                                        <img x-show="imagePreview3" :src="imagePreview3"
                                                            alt="Image Preview 3" class="w-full h-full mb-4">

                                                        <p x-show="!imagePreview3"
                                                            class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                                class="font-semibold">Click to upload</span> or drag and
                                                            drop
                                                        </p>
                                                        <p x-show="!imagePreview3"
                                                            class="text-xs text-gray-500 dark:text-gray-400">
                                                            SVG,
                                                            PNG, JPG or GIF (MAX.
                                                            800x400px)</p>
                                                    </div>
                                                    <input id="dropzone-file-3" name="photo" type="file" class="hidden"
                                                        @change="previewImage(3, $event)">
                                                </label>
                                            </div>
                                            <x-input-error :messages="$errors->get('photo')" class="text-start mt-2" />
                                        </div>
                                        <div>
                                            <div>
                                                <div> ID:</div>
                                                <div class=" flex gap-x-3 flex-col w-full">
                                                    <div>
                                                        <img class=" rounded-md h-28" src="/images/id-front.webp"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div>Picture</div>
                                                <div>
                                                    <img class=" h-28" src="/images/your-picture.jpeg" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="pt-4">
                                        <button class="btn loginBtn rounded btn-block" id="recaptcha"
                                            type="submit">Submit</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <script>
            function init() {
                return {
                    imagePreview1: null,
                    imagePreview2: null,
                    imagePreview3: null,

                    previewImage(index, event) {
                        const file = event.target.files[0];
                        if (file && file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = () => {
                                this['imagePreview' + index] = reader.result;
                            };
                            reader.readAsDataURL(file);
                        } else {
                            this['imagePreview' + index] = null;
                        }
                    },


                };
            };
        </script>
    @elseif (auth()->user()->kyc->pending)
        <div class="main-container" x-data="init()">

            <div class="container h-100 ">
                <div class="row h-100">
                    <div class="col-12 align-self-center mb-4">
                        <div class="row justify-content-center">
                            Your kyc approval is pending, we'll get back to you in no time.
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    @else
        <div class="main-container" x-data="init()">
            <div class="container h-100 ">
                <div class="row h-100">
                    <div class="col-12 align-self-center mb-4">
                        <div class="row justify-content-center">
                            Your account is verified.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endcomponent
