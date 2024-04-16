<?php
    $canWrap = $canWrap();
?>

<div
    <?php echo e($attributes
            ->merge($getExtraAttributes(), escape: false)
            ->class([
                'fi-ta-color flex gap-1.5',
                'flex-wrap' => $canWrap,
                'px-3 py-4' => ! $isInline(),
            ])); ?>

>
    <!--[if BLOCK]><![endif]--><?php if(count($arrayState = \Illuminate\Support\Arr::wrap($getState()))): ?>
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $arrayState; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $itemIsCopyable = $isCopyable($state);
                $copyableState = $getCopyableState($state) ?? $state;
                $copyMessage = $getCopyMessage($state);
                $copyMessageDuration = $getCopyMessageDuration($state);
            ?>

            <div
                <?php if($itemIsCopyable): ?>
                    x-on:click="
                        window.navigator.clipboard.writeText(<?php echo \Illuminate\Support\Js::from($copyableState)->toHtml() ?>)
                        $tooltip(<?php echo \Illuminate\Support\Js::from($copyMessage)->toHtml() ?>, {
                            theme: $store.theme,
                            timeout: <?php echo \Illuminate\Support\Js::from($copyMessageDuration)->toHtml() ?>,
                        })
                    "
                <?php endif; ?>
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'fi-ta-color-item h-6 w-6 rounded-md',
                    'cursor-pointer' => $itemIsCopyable,
                ]); ?>"
                style="<?php echo \Illuminate\Support\Arr::toCssStyles([
                    "background-color: {$state}" => $state,
                ]) ?>"
            ></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    <?php elseif(($placeholder = $getPlaceholder()) !== null): ?>
        <?php if (isset($component)) { $__componentOriginal2078c004f342b84f8f2b0f2ab3478754 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2078c004f342b84f8f2b0f2ab3478754 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-tables::components.columns.placeholder','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament-tables::columns.placeholder'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            <?php echo e($placeholder); ?>

         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2078c004f342b84f8f2b0f2ab3478754)): ?>
<?php $attributes = $__attributesOriginal2078c004f342b84f8f2b0f2ab3478754; ?>
<?php unset($__attributesOriginal2078c004f342b84f8f2b0f2ab3478754); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2078c004f342b84f8f2b0f2ab3478754)): ?>
<?php $component = $__componentOriginal2078c004f342b84f8f2b0f2ab3478754; ?>
<?php unset($__componentOriginal2078c004f342b84f8f2b0f2ab3478754); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH T:\Notes\php-laravel\filament-yelo-code\vendor\filament\tables\src\/../resources/views/columns/color-column.blade.php ENDPATH**/ ?>