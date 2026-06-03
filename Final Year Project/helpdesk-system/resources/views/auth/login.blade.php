<x-app-layout>
    <div style="min-height: 80vh; display:flex; align-items:center; justify-content:center; padding:40px 20px;">
        <div style="background:rgba(255,255,255,0.92); border:1px solid #e8eaf0; border-radius:20px; padding:40px; width:100%; max-width:420px; box-shadow:0 8px 40px rgba(99,102,241,0.1); animation:fadeUp 0.6s ease both;">

            <!-- Header -->
            <div style="text-align:center; margin-bottom:28px;">
                <div style="font-size:22px; font-weight:800; color:#0f172a; margin-bottom:6px;">
                    Welcome back to <span style="color:#6366f1;">NovaSupport</span>
                </div>
                <div style="font-size:12px; color:#64748b;">Sign in to manage your support requests</div>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div style="background:#dcfce7; color:#15803d; padding:10px 14px; border-radius:10px; font-size:12px; margin-bottom:16px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div style="margin-bottom:16px;">
                    <label style="font-size:12px; font-weight:600; color:#0f172a; display:block; margin-bottom:6px;">
                        <i class="fa-regular fa-envelope" style="color:#6366f1; margin-right:5px;"></i> Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; transition:all 0.3s; background:rgba(255,255,255,0.9);"
                        onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                        placeholder="you@example.com"/>
                    @error('email')
                        <div style="color:#dc2626; font-size:11px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div style="margin-bottom:16px;">
                    <label style="font-size:12px; font-weight:600; color:#0f172a; display:block; margin-bottom:6px;">
                        <i class="fa-solid fa-lock" style="color:#6366f1; margin-right:5px;"></i> Password
                    </label>
                    <input type="password" name="password" required
                        style="width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:12px; outline:none; transition:all 0.3s; background:rgba(255,255,255,0.9);"
                        onfocus="this.style.borderColor='#6366f1'; this.style.boxShadow='0 0 0 3px rgba(99,102,241,0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow=''"
                        placeholder="••••••••"/>
                    @error('password')
                        <div style="color:#dc2626; font-size:11px; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                    <label style="display:flex; align-items:center; gap:6px; font-size:12px; color:#64748b; cursor:pointer;">
                        <input type="checkbox" name="remember" style="accent-color:#6366f1;"/>
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:12px; color:#6366f1; text-decoration:none; font-weight:500;">Forgot password?</a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-nova" style="width:100%; justify-content:center; padding:11px 20px; font-size:13px;">
                    <span><i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In</span>
                </button>
            </form>

            <!-- Register Link -->
            <div style="text-align:center; margin-top:20px; font-size:12px; color:#64748b;">
                Don't have an account?
                <a href="{{ route('register') }}" style="color:#6366f1; font-weight:600; text-decoration:none;">Create one →</a>
            </div>
        </div>
    </div>
</x-app-layout>
