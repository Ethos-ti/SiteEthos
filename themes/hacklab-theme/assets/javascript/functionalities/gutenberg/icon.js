import { RichTextToolbarButton } from '@wordpress/block-editor';
import { Button, Modal, Path, SVG, TextControl } from '@wordpress/components';
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { getActiveFormat, registerFormatType, removeFormat, toggleFormat } from '@wordpress/rich-text';

import 'iconify-icon';

const FORMAT_NAME = 'hacklabr/iconify';
const FORMAT_TITLE = __('Icon');

function ToolbarIcon ({ size }) {
    return (
        <SVG height={size} width={size} viewBox="-4 -4 32 32">
            <Path d="M12 19.5c3.75 0 7.159-3.379 6.768-4.125c-.393-.75-2.268 1.875-6.768 1.875s-6-2.625-6.375-1.875S8.25 19.5 12 19.5m4.125-12c.623 0 1.125.502 1.125 1.125v1.5c0 .623-.502 1.125-1.125 1.125A1.123 1.123 0 0 1 15 10.125v-1.5c0-.623.502-1.125 1.125-1.125m-8.25 0C8.498 7.5 9 8.002 9 8.625v1.5c0 .623-.502 1.125-1.125 1.125a1.123 1.123 0 0 1-1.125-1.125v-1.5c0-.623.502-1.125 1.125-1.125M12 0C5.381 0 0 5.381 0 12s5.381 12 12 12s12-5.381 12-12S18.619 0 12 0m0 1.5c5.808 0 10.5 4.692 10.5 10.5S17.808 22.5 12 22.5S1.5 17.808 1.5 12S6.192 1.5 12 1.5"/>
        </SVG>
    )
}

function Edit ({ isActive, value, onChange, onFocus }) {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [iconifyId, setIconifyId] = useState('');

    function closeModal () {
        setIsModalOpen(false);
    }

    function openModal () {
        setIconifyId('');
        setIsModalOpen(true);
    }

    function toggleIcon () {
        if (getActiveFormat(value, FORMAT_NAME)) {
            onChange(removeFormat(value, FORMAT_NAME));
        } else {
            openModal();
        }
    }

    function insertIcon () {
        if (iconifyId) {
            closeModal();
            onChange(toggleFormat(value, {
                type: FORMAT_NAME,
                attributes: {
                    icon: iconifyId,
                }
            }));
            onFocus();
        }
    }

    return <>
        <RichTextToolbarButton
            icon={ToolbarIcon}
            isActive={isActive}
            title={FORMAT_TITLE}
            onClick={toggleIcon}
        />
        {(isModalOpen) ? (
            <Modal title={FORMAT_TITLE} onRequestClose={closeModal}>
                <TextControl
                    label={__('Iconify ID', 'hacklabr')}
                    value={iconifyId}
                    onChange={setIconifyId}
                />
                <Button
                    disabled={!iconifyId}
                    variant="primary"
                    onClick={insertIcon}
                >
                    {__('Done')}
                </Button>
            </Modal>
        ) : null}
    </>;
}

registerFormatType(FORMAT_NAME, {
    title: FORMAT_TITLE,
    tagName: 'iconify-icon',
    className: null,
    attributes: {
        icon: 'icon',
    },
    edit: Edit,
});
