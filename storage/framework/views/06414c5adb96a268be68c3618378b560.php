
<div>
    <form wire:submit.prevent="login">
        <!-- Email Field -->
        <div class="input-group-custom">
            <div class="input-icon">
                <i class="fas fa-envelope"></i>
                <input 
                    type="email" 
                    wire:model="email" 
                    placeholder="Email Address"
                    autocomplete="email"
                    autofocus
                >
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo e($message); ?></span>
                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Password Field -->
        <div class="input-group-custom">
            <div class="input-icon">
                <i class="fas fa-lock"></i>
                <input 
                    type="password" 
                    wire:model="password" 
                    placeholder="Password"
                    autocomplete="current-password"
                >
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo e($message); ?></span>
                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <!-- Login Button with Loading State -->
        <button 
            type="submit" 
            class="btn-login"
            wire:loading.attr="disabled"
            wire:loading.class="loading"
        >
            <span wire:loading.remove>
                <i class="fas fa-sign-in-alt"></i>
                Login
            </span>
            <span wire:loading>
                <i class="fas fa-spinner"></i>
                Authenticating...
            </span>
        </button>
    </form>
</div><?php /**PATH C:\xampp\htdocs\ERP-System\resources\views\livewire\auth\login.blade.php ENDPATH**/ ?>