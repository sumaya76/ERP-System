<div class="container mt-5" style="max-width:500px">
    <form wire:submit.prevent="save">

        <input type="text" wire:model="name" class="form-control mb-2" placeholder="Name">

        <input type="email" wire:model="email" class="form-control mb-2" placeholder="Email">

        <input type="password" wire:model="password" class="form-control mb-2" placeholder="Password">

        <select wire:model="role_id" class="form-control mb-2">
            <option value="">Select Role</option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </select>

        <button class="btn btn-success w-100">
            Create User
        </button>

    </form>
</div>
<?php /**PATH C:\xampp\htdocs\ERP-System\resources\views\livewire\users\create.blade.php ENDPATH**/ ?>