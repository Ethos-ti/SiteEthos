import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { BaseControl, Button } from '@wordpress/components';
import { __experimentalVStack as VStack } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const RESET_IMAGE = { alt: '', height: 0, url: '', width: 0, _isReset: true };

function ImagePreview ({ image, label, open, resetImage }) {
    return (
        <BaseControl label={label}>
            {(image?.url) ? (
                <VStack>
                    <img alt={image.alt} height={image.height} src={image.url} width={image.width} tabIndex={0} onClick={open}/>
                    <Button variant="secondary" onClick={open}>
                        {__('Change image', 'hacklabr')}
                    </Button>
                    <Button variant="secondary" isDestructive={true} onClick={resetImage}>
                        {__('Remove image', 'hacklabr')}
                    </Button>
                </VStack>
            ) : (
                <VStack>,
                    <Button variant="primary" onClick={open}>
                        {__('Select image', 'hacklabr')}
                    </Button>
                </VStack>
            )}
        </BaseControl>
    )
}

export function SelectImage ({ label = __('Image', 'hacklabr'), value, onChange }) {
    const resetImage = () => onChange(RESET_IMAGE);

    return (
        <MediaUploadCheck>
            <MediaUpload
                allowedTypes={['image']}
                onSelect={onChange}
                value={value?.id}
                render={({ open }) => (
                    <ImagePreview
                        label={label}
                        image={value}
                        open={open}
                        resetImage={resetImage}
                    />
                )}
            />
        </MediaUploadCheck>
    )
}
