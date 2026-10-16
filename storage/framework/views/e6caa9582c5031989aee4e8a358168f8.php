<label class="flex items-start gap-3 text-sm text-gray-600">
    <input type="checkbox" name="consent" value="1" required <?php if(old('consent')): echo 'checked'; endif; ?> class="mt-1 rounded border-gray-300">
    <span>Acepto la <a href="<?php echo e(route('privacy')); ?>" class="underline">política de privacidad</a> y la publicación de mi nombre y contenido tras su revisión. Confirmo que tengo los derechos y permisos de las personas que aparecen, incluidos los de sus representantes legales si son menores.</span>
</label>
<?php /**PATH C:\Users\Alberto Martín\Google Drive\PHP\Git Alberto\SVAclubsportal\resources\views/webclubs/stories/_consent.blade.php ENDPATH**/ ?>