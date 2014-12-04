<section class="filters">
    <div class="container">
        <div class="collapsible animate-slide on" ng-class="{'on': filtersOpen}" style="max-height: 301px;">
            <form class="vertical ng-pristine ng-valid" name="filterForm" shift-submit="performFilters()" novalidate="">
                <div class="row">
                    <div class="column-half">
                        <h2>Filters</h2>
                    </div>
                    <div class="column-half text-right close-button-column">
                        <a href="javascript:;" ng-click="filtersOpen = false"><span class="icon-close"></span></a>
                    </div>
                </div>

                <!-- ngRepeat: fieldGroup in filterFieldsChunks --><div class="row islet ng-scope" ng-repeat="fieldGroup in filterFieldsChunks">
                    <!-- ngRepeat: field in fieldGroup --><div class="column-third ng-scope" ng-repeat="field in fieldGroup">
                        <div class="control custom-field-control">
                            <div class="control-label">
                                <label for="keyword" class="ng-binding">Keyword</label>
                            </div>
                            <div class="control-field">
                                <div ng-form="" name="name fieldControlForm" field-control="" field="field" class="ng-pristine ng-valid">
        <div ng-include="include"><input type="text" id="keyword" name="keyword" placeholder="" ng-model="field.value" validator="" class="ng-scope ng-pristine ng-valid">
    </div>
        <div ng-show="field.description" class="help-text ng-binding">Search by entry name, or the user's first or last name.</div>

        <div field-validation-errors="field" class="ng-isolate-scope ng-scope"><!-- ngRepeat: (key, value) in messages --></div>
    </div>
                            </div>
                        </div>
                    </div><div class="column-third ng-scope" ng-repeat="field in fieldGroup">
                        <div class="control custom-field-control">
                            <div class="control-label">
                                <label for="entry_status" class="ng-binding">Status</label>
                            </div>
                            <div class="control-field">
                                <div ng-form="" name="name fieldControlForm" field-control="" field="field" class="ng-pristine ng-valid">
        <div ng-include="include"><select id="entry_status" name="entry_status" ng-model="field.value" ng-options="option.value as option.label for option in field.options" validator="" class="ng-scope ng-pristine ng-valid"><option value="" class=""></option><option value="0">Submitted</option><option value="1">Disqualified</option><option value="2">In progress</option></select>
    </div>
        <div ng-show="field.description" class="help-text ng-binding">Filter results by status.</div>

        <div field-validation-errors="field" class="ng-isolate-scope ng-scope"><!-- ngRepeat: (key, value) in messages --></div>
    </div>
                            </div>
                        </div>
                    </div><div class="column-third ng-scope" ng-repeat="field in fieldGroup">
                        <div class="control custom-field-control">
                            <div class="control-label">
                                <label for="category_id" class="ng-binding">Category</label>
                            </div>
                            <div class="control-field">
                                <div ng-form="" name="name fieldControlForm" field-control="" field="field" class="ng-pristine ng-valid">
        <div ng-include="include"><select id="category_id" name="category_id" ng-model="field.value" ng-options="option.value as option.label for option in field.options" validator="" class="ng-scope ng-pristine ng-valid"><option value="" class=""></option><option value="0" selected="selected">All categories</option><option value="1">Food/cuisine</option><option value="2">Drinks/beverages</option><option value="3">Schwarzkopf: Apprentice Student of the Year</option><option value="4">Sports fanatics</option><option value="5">Friday fun</option><option value="6">Parent category</option></select>
    </div>
        <div ng-show="field.description" class="help-text ng-binding">Display only entries from a certain category.</div>

        <div field-validation-errors="field" class="ng-isolate-scope ng-scope"><!-- ngRepeat: (key, value) in messages --></div>
    </div>
                            </div>
                        </div>
                    </div>
                </div><div class="row islet ng-scope" ng-repeat="fieldGroup in filterFieldsChunks">
                    <!-- ngRepeat: field in fieldGroup --><div class="column-third ng-scope" ng-repeat="field in fieldGroup">
                        <div class="control custom-field-control">
                            <div class="control-label">
                                <label for="chapter" class="ng-binding">Country</label>
                            </div>
                            <div class="control-field">
                                <div ng-form="" name="name fieldControlForm" field-control="" field="field" class="ng-pristine ng-valid">
        <div ng-include="include"><select id="chapter" name="chapter" ng-model="field.value" ng-options="option.value as option.label for option in field.options" validator="" class="ng-scope ng-pristine ng-valid"><option value="" class=""></option><option value="0">Australia</option><option value="1">China</option><option value="2">New Zealand</option></select>
    </div>
        <div ng-show="field.description" class="help-text ng-binding">Display only entries from a particular country.</div>

        <div field-validation-errors="field" class="ng-isolate-scope ng-scope"><!-- ngRepeat: (key, value) in messages --></div>
    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row island">
                    <input type="submit" class="button" value="Filter">
                    <a href="javascript:;" class="button secondary" ng-click="resetFilters()">Reset</a>
                </div>
            </form>
        </div>

        <div class="active-filters">
            <ul class="horizontal expanded">
                <!-- ngRepeat: filter in activeFilters -->
            </ul>
        </div>

        <a href="javascript:;" id="filter-toggle" class="button small secondary" ng-class="{secondary: filtersOpen}" ng-click="filtersOpen = !filtersOpen">Search <span class="icon-search"></span></a>
    </div>
    </section>