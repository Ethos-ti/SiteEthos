import { PanelBody, PanelRow, QueryControls, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { useRestApi } from './hooks';
import { EMPTY_ARR } from './utils';
import { SelectCompare } from './SelectCompare';
import { SelectPostType } from './SelectPostType';
import { SelectTaxonomy } from './SelectTaxonomy';
import { SelectTerms } from './SelectTerms';

export function QueryPanel ({ attributes, setAttributes, title = __('Query', 'hacklabr') }) {
    const { compare, noCompare, noPostType, noQueryTerms, noTaxonomy, order, orderBy, postType, queryTerms, showChildren, taxonomy } = attributes;

    const { data: postTypes } = useRestApi('hacklabr/v2/post_types');

    const onPostTypeChange = (postType) => setAttributes({ postType, taxonomy: '', queryTerms: EMPTY_ARR });
    const onNoPostTypeChange = (noPostType) => setAttributes({ noPostType, noTaxonomy: '', noQueryTerms: EMPTY_ARR });

    const onTaxonomyChange = (taxonomy) => setAttributes({ taxonomy, queryTerms: EMPTY_ARR });
    const onNoTaxonomyChange = (noTaxonomy) => setAttributes({ noTaxonomy, noQueryTerms: EMPTY_ARR });

    return (
        <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={title}>
            <PanelRow>
                <SelectPostType
                    required={true}
                    value={postType}
                    onChange={onPostTypeChange}
                />
            </PanelRow>

            {(postTypes?.[postType]?.hierarchical) ? (
                <PanelRow>
                    <ToggleControl
                        label={__('Show children posts?', 'hacklabr')}
                        checked={showChildren}
                        onChange={(showChildren) => setAttributes({ showChildren })}
                    />
                </PanelRow>
            ) : null}

            <PanelRow>
                <SelectTaxonomy
                    postType={postType}
                    value={taxonomy}
                    onChange={onTaxonomyChange}
                />
            </PanelRow>

            {(taxonomy) ? (
                <PanelRow>
                    <SelectTerms
                        taxonomy={taxonomy}
                        value={queryTerms}
                        onChange={(queryTerms) => setAttributes({ queryTerms })}
                    />
                </PanelRow>
            ) : null}

            {(queryTerms.length > 1) ? (
                <PanelRow>
                    <SelectCompare
                        value={compare}
                        onChange={(compare) => setAttributes({ compare })}
                    />
                </PanelRow>
            ) : null}

            <PanelRow>
                <QueryControls
                    order={order}
                    orderBy={orderBy}
                    onOrderChange={(order) => setAttributes({ order })}
                    onOrderByChange={(orderBy) => setAttributes({ orderBy })}
                />
            </PanelRow>

            <PanelRow>
                <h2>{__('Filter posts to not display', 'hacklabr')}</h2>
            </PanelRow>

            <PanelRow>
                <SelectPostType
                    value={noPostType}
                    onChange={onNoPostTypeChange}
                />
            </PanelRow>

            {(noPostType) ? (
                <PanelRow>
                    <SelectTaxonomy
                        postType={noPostType}
                        value={noTaxonomy}
                        onChange={onNoTaxonomyChange}
                    />
                    </PanelRow>
                ) : null}

            {(noTaxonomy) ? (
                <PanelRow>
                    <SelectTerms
                        taxonomy={noTaxonomy}
                        value={noQueryTerms}
                        onChange={(noQueryTerms) => setAttributes({ noQueryTerms })}
                    />
                </PanelRow>
            ) : null}

            {(noQueryTerms.length > 1) ? (
                <PanelRow>
                    <SelectCompare
                        value={noCompare}
                        onChange={(noCompare) => setAttributes({ noCompare })}
                    />
                </PanelRow>
            ) : null}
        </PanelBody>
    );
}
