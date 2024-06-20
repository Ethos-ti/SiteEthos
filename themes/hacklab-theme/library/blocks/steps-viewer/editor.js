import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { Circle, PanelBody, PanelRow, SVG } from '@wordpress/components';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';
import { __, sprintf } from '@wordpress/i18n';
import clsx from 'clsx';

import { loop } from '../shared/utils';

import metadata from './block.json';

function Step ({ active = false }) {
    const className = clsx('steps-viewer__step', { 'steps-viewer__step--active': active });

    const radius = 10;
    const height = 2 * radius;

    return (
        <SVG className={className} height={height} width={height} viewBox={`0 0 ${height} ${height}`}>
            <Circle cx={radius} cy={radius} r={radius}/>
        </SVG>
    );
}

function Edit ({ attributes, setAttributes }) {
    const { current, total } = attributes;

    const blockProps = useBlockProps({ className: 'steps-viewer' });

    return <>
        <InspectorControls>
            <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={__('Steps', 'hacklabr')}>
                <PanelRow>
                    <NumberControl
                        label={__('Current step', 'hacklabr')}
                        max={total}
                        min={1}
                        value={current}
                        onChange={(value) => setAttributes({ current: parseInt(value) })}
                    />
                </PanelRow>

                <PanelRow>
                    <NumberControl
                        label={__('Last step', 'hacklabr')}
                        min={current}
                        value={total}
                        onChange={(value) => setAttributes({ total: parseInt(value) })}
                    />
                </PanelRow>
            </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
            <div className="steps-viewer__steps" title={sprintf(__('Step %s of %s', 'hacklabr'), current, total)}>
                {loop(total, (index) => (
                    <Step key={index} active={index < current}/>
                ))}
            </div>
        </div>
    </>;
}

function Save ({ attributes }) {
    const { current, total } = attributes;

    const blockProps = useBlockProps.save({ className: 'steps-viewer' });

    return (
        <div {...blockProps}>
            <div className="steps-viewer__steps" title={sprintf(__('Step %s of %s', 'hacklabr'), current, total)}>
                {loop(total, (index) => (
                    <Step key={index} active={index < current}/>
                ))}
            </div>
        </div>
    );
}

registerBlockType(metadata.name, {
    edit: Edit,
    save: Save,
})
