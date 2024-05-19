import { PanelBody, PanelRow, QueryControls, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import { useRestApi } from './hooks';
import { SelectCompare } from './SelectCompare';
import { SelectPostType } from './SelectPostType';
import { SelectTaxonomy } from './SelectTaxonomy';
import { SelectTerms } from './SelectTerms';

export function QueryPanel ({ attributes, setAttributes, title = __('Query', 'hacklabr') }) {
    const { compare, noCompare, noPostType, noQueryTerms, noTaxonomy, order, orderBy, postType, queryTerms, showChildren, taxonomy } = attributes;

    const postTypes = useRestApi('hacklabr/v2/post_types');

    const onCompareChange = (compare) => setAttributes({ compare });

    const onOrderChange = (order) => setAttributes({ order });
    const onOrderByChange = (orderBy) => setAttributes({ orderBy });

    const onPostTypeChange = (postType) => setAttributes({ postType, taxonomy: '', queryTerms: [] });

    const onShowChildrenChange = (showChildren) => setAttributes({ showChildren });

    const onQueryTermsChange = (queryTerms) => setAttributes({ queryTerms });

    const onTaxonomyChange = (taxonomy) => setAttributes({ taxonomy, queryTerms: [] });

    return (
        <PanelBody className="hacklabr-gutenberg-panel__panel-body" title={title}>
            <PanelRow>
                <SelectPostType value={postType} onChange={onPostTypeChange}/>
            </PanelRow>

            {(postTypes?.[postType]?.hierarchical) ? (
                <PanelRow>
                    <ToggleControl
                        label={__('Show children posts?', 'hacklabr')}
                        checked={showChildren}
                        onChange={onShowChildrenChange}
                    />
                </PanelRow>
            ) : null}

            <PanelRow>
                <SelectTaxonomy postType={postType} value={taxonomy} onChange={onTaxonomyChange}/>
            </PanelRow>

            {(taxonomy) ? (
                <PanelRow>
                    <SelectTerms taxonomy={taxonomy} value={queryTerms} onChange={onQueryTermsChange}/>
                </PanelRow>
            ) : null}

            {(queryTerms.length > 1) ? (
                <PanelRow>
                    <SelectCompare value={compare} onChange={onCompareChange}/>
                </PanelRow>
            ) : null}

            <PanelRow>
                <QueryControls
                    order={order}
                    orderBy={orderBy}
                    onOrderChange={onOrderChange}
                    onOrderByChange={onOrderByChange}
                />
            </PanelRow>
        </PanelBody>
    );
}
