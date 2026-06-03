<x-app-layout>
    <div style="padding:30px; animation:fadeUp 0.6s ease both;">
        <div style="max-width:640px; margin:0 auto;">
            <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:20px; padding:36px; box-shadow:0 8px 40px rgba(99,102,241,0.08);">

                <!-- Header -->
                <div style="margin-bottom:28px;">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                        <div style="width:40px; height:40px; background:linear-gradient(135deg,#ede9fe,#ddd6fe); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                            <i class="fa-solid fa-user-plus" style="color:#7c3aed; font-size:18px;"></i>
                        </div>
                        <div style="font-size:20px; font-weight:800; color:#0f172a;">Join NovaSupport</div>
                    </div>
                    <div style="font-size:12px; color:#64748b;">Create your account to get started</div>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Full Name -->
                    <div style="margin-bottom:16px;">
                        <label style="font-size:12px; font-weight:600; color:#0f172a; display:block; margin-bottom:6px;">
                            <i class="fa-solid fa-user" style="color:#6366f1; margin-right:5px;"></i> Full Name
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            style="width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; transition:all 0.3s;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                            placeholder="John Doe"/>
                        @error('name')
                            <div style="color:#dc2626; font-size:11px; margin-top:4px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div style="margin-bottom:16px;">
                        <label style="font-size:12px; font-weight:600; color:#0f172a; display:block; margin-bottom:6px;">
                            <i class="fa-solid fa-envelope" style="color:#6366f1; margin-right:5px;"></i> Email Address
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            style="width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; transition:all 0.3s;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                            placeholder="you@example.com"/>
                        @error('email')
                            <div style="color:#dc2626; font-size:11px; margin-top:4px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom:16px;">
                        <label style="font-size:12px; font-weight:600; color:#0f172a; display:block; margin-bottom:6px;">
                            <i class="fa-solid fa-lock" style="color:#6366f1; margin-right:5px;"></i> Password
                        </label>
                        <input type="password" name="password" required
                            style="width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; transition:all 0.3s;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                            placeholder="At least 8 characters"/>
                        @error('password')
                            <div style="color:#dc2626; font-size:11px; margin-top:4px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div style="margin-bottom:20px;">
                        <label style="font-size:12px; font-weight:600; color:#0f172a; display:block; margin-bottom:6px;">
                            <i class="fa-solid fa-lock" style="color:#6366f1; margin-right:5px;"></i> Confirm Password
                        </label>
                        <input type="password" name="password_confirmation" required
                            style="width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; transition:all 0.3s;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                            onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                            placeholder="Confirm your password"/>
                    </div>

                    <!-- Hidden role field -->
                    <input type="hidden" name="role" value="customer">

                    <!-- Submit -->
                    <button type="submit" class="btn-nova" style="width:100%; justify-content:center; padding:11px 20px; font-size:13px;">
                        <span><i class="fa-solid fa-user-plus"></i> Create Account</span>
                    </button>

                    <!-- Login Link -->
                    <div style="text-align:center; font-size:12px; color:#64748b; margin-top:16px;">
                        Already have an account? <a href="{{ route('login') }}" style="color:#6366f1; font-weight:600; text-decoration:none;">Sign in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>