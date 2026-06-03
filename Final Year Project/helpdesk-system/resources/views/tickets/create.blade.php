@if(request()->has('ajax'))
    <div style="padding:30px; animation:fadeUp 0.6s ease both;">
        <div style="max-width:640px; margin:0 auto;">
            <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:20px; padding:36px; box-shadow:0 8px 40px rgba(99,102,241,0.08);">

                <!-- Header -->
                <div style="margin-bottom:28px;">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                        <div style="width:40px; height:40px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                            <i class="fa-regular fa-envelope" style="color:#7c3aed; font-size:17px;"></i>
                        </div>
                        <div style="font-size:20px; font-weight:800; color:#0f172a;">Submit a Support Request</div>
                    </div>
                    <div style="font-size:12px; color:#64748b;">Describe your issue and our AI will generate an instant reply for you.</div>
                </div>

                <form method="POST" action="{{ route('tickets.store') }}">
                    @csrf

                    <!-- Title -->
                    <div style="margin-bottom:20px;">
                        <label style="font-size:12px; font-weight:600; color:#0f172a; display:block; margin-bottom:6px;">
                            <i class="fa-solid fa-heading" style="color:#6366f1; margin-right:5px;"></i> Request Title
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            style="width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; transition:all 0.3s;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                            placeholder="e.g. Cannot reset my password"/>
                        @error('title')
                            <div style="color:#dc2626; font-size:11px; margin-top:4px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div style="margin-bottom:24px;">
                        <label style="font-size:12px; font-weight:600; color:#0f172a; display:block; margin-bottom:6px;">
                            <i class="fa-solid fa-align-left" style="color:#6366f1; margin-right:5px;"></i> Describe Your Issue
                        </label>
                        <textarea name="description" required rows="5"
                            style="width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; transition:all 0.3s; resize:vertical; font-family:inherit;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                            placeholder="Please describe your issue in detail...">{{ old('description') }}</textarea>
                        @error('description')
                            <div style="color:#dc2626; font-size:11px; margin-top:4px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                   <!-- Support Notice -->
                    <div style="background:linear-gradient(135deg,#f5f3ff,#eef2ff); border:1px solid #ddd6fe; border-radius:12px; padding:12px 14px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
                        <i class="fa-solid fa-headset" style="color:#7c3aed; font-size:16px;"></i>
                        <div style="font-size:11px; color:#5b21b6; line-height:1.5;"><strong>Our Support Team</strong> will review your request and get back to you as soon as possible. Average response time: under 2 minutes.</div>
                    </div>
                    
                    <div style="display:flex; gap:10px;">
                        <a href="{{ route('tickets.index') }}" class="ajax-link" data-url="{{ route('tickets.index') }}" style="flex:1; text-align:center; padding:11px; border-radius:99px; border:1.5px solid #e2e8f0; font-size:12px; font-weight:600; color:#64748b; text-decoration:none; transition:all 0.3s;" onmouseover="this.style.borderColor='#6366f1'; this.style.color='#6366f1'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn-nova" style="flex:2; justify-content:center; padding:11px 20px; font-size:13px;">
                            <span><i class="fa-solid fa-paper-plane"></i> Submit Request</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@else
    <x-app-layout>
        <div style="padding:30px; animation:fadeUp 0.6s ease both;">
            <div style="max-width:640px; margin:0 auto;">
                <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:20px; padding:36px; box-shadow:0 8px 40px rgba(99,102,241,0.08);">

                    <!-- Header -->
                    <div style="margin-bottom:28px;">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                            <div style="width:40px; height:40px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                                <i class="fa-regular fa-envelope" style="color:#7c3aed; font-size:17px;"></i>
                            </div>
                            <div style="font-size:20px; font-weight:800; color:#0f172a;">Submit a Support Request</div>
                        </div>
                        <div style="font-size:12px; color:#64748b;">Describe your issue and our AI will generate an instant reply for you.</div>
                    </div>

                    <form method="POST" action="{{ route('tickets.store') }}">
                        @csrf

                        <!-- Title -->
                        <div style="margin-bottom:20px;">
                            <label style="font-size:12px; font-weight:600; color:#0f172a; display:block; margin-bottom:6px;">
                                <i class="fa-solid fa-heading" style="color:#6366f1; margin-right:5px;"></i> Request Title
                            </label>
                            <input type="text" name="title" value="{{ old('title') }}" required
                                style="width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; transition:all 0.3s;"
                                onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                                onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                                placeholder="e.g. Cannot reset my password"/>
                            @error('title')
                                <div style="color:#dc2626; font-size:11px; margin-top:4px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div style="margin-bottom:24px;">
                            <label style="font-size:12px; font-weight:600; color:#0f172a; display:block; margin-bottom:6px;">
                                <i class="fa-solid fa-align-left" style="color:#6366f1; margin-right:5px;"></i> Describe Your Issue
                            </label>
                            <textarea name="description" required rows="5"
                                style="width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; transition:all 0.3s; resize:vertical; font-family:inherit;"
                                onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                                onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                                placeholder="Please describe your issue in detail...">{{ old('description') }}</textarea>
                            @error('description')
                                <div style="color:#dc2626; font-size:11px; margin-top:4px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                       <!-- Support Notice -->
                        <div style="background:linear-gradient(135deg,#f5f3ff,#eef2ff); border:1px solid #ddd6fe; border-radius:12px; padding:12px 14px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
                            <i class="fa-solid fa-headset" style="color:#7c3aed; font-size:16px;"></i>
                            <div style="font-size:11px; color:#5b21b6; line-height:1.5;"><strong>Our Support Team</strong> will review your request and get back to you as soon as possible. Average response time: under 2 minutes.</div>
                        </div>
                        
                        <div style="display:flex; gap:10px;">
                            <a href="{{ route('tickets.index') }}" class="ajax-link" data-url="{{ route('tickets.index') }}" style="flex:1; text-align:center; padding:11px; border-radius:99px; border:1.5px solid #e2e8f0; font-size:12px; font-weight:600; color:#64748b; text-decoration:none; transition:all 0.3s;" onmouseover="this.style.borderColor='#6366f1'; this.style.color='#6366f1'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">
                                <i class="fa-solid fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn-nova" style="flex:2; justify-content:center; padding:11px 20px; font-size:13px;">
                                <span><i class="fa-solid fa-paper-plane"></i> Submit Request</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif