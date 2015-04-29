<style type="text/css">
    /***************************** Required styles *****************************/

/**
 * For the correct positioning of the placeholder element, the dnd-list and
 * it's children must have position: relative
 */
.advancedDemo ul[dnd-list],
.advancedDemo ul[dnd-list] > li {
    position: relative;
}

/***************************** Dropzone Styling *****************************/

/**
 * The dnd-list should always have a min-height,
 * otherwise you can't drop to it once it's empty
 */
.advancedDemo .dropzone ul[dnd-list] {
    min-height: 42px;
    margin: 0px;
    padding-left: 0px;
}

/**
 * The dnd-lists's child elements currently MUST have
 * position: relative. Otherwise we can not determine
 * whether the mouse pointer is in the upper or lower
 * half of the element we are dragging over. In other
 * browsers we can use event.offsetY for this.
 */
.advancedDemo .dropzone li {
    display: block;
}

/**
 * Reduce opacity of elements during the drag operation. This allows the user
 * to see where he is dropping his element, even if the element is huge. The
 * .dndDragging class is automatically set during the drag operation.
 */
.advancedDemo .dropzone .dndDragging {
    opacity: 0.7;
}

/**
 * The dndDraggingSource class will be applied to the source element of a drag
 * operation. It makes sense to hide it to give the user the feeling that he's
 * actually moving it. Note that the source element has also .dndDragging class.
 */
.advancedDemo .dropzone .dndDraggingSource {
    display: none;
}

/**
 * An element with .dndPlaceholder class will be added as child of the dnd-list
 * while the user is dragging over it.
 */
.advancedDemo .dropzone .dndPlaceholder {
    background-color: #ddd !important;
    min-height: 42px;
    display: block;
    position: relative;
    border: 2px solid red;
}

.dndPlaceholder {    
    border: 2px solid red;
}

/***************************** Element type specific styles *****************************/

.advancedDemo .dropzone .itemlist {
    min-height: 120px !important;
}

.advancedDemo .dropzone .itemlist > li {
    background-color: #337ab7;
    border: none;
    border-radius: .25em;
    color: #fff;
    float: left;
    font-weight: 700;
    height: 50px;
    margin: 5px;
    padding: 3px;
    text-align: center;
    width: 50px;
}

.advancedDemo .dropzone .container-element {
    margin: 10px;
}
</style>
<div ng-controller="TestRepeatController" class="advancedDemo">
    <div class="row">        
        <div class="container-element box box-blue">
            <h3>Container</h3>
            <ul dnd-list="items"
                dnd-allowed-types="['itemType']"
                dnd-horizontal-list="true"
                dnd-external-sources="true"
                dnd-dragover="dragoverCallback(event, index, external, type)"
                dnd-drop="dropCallback(event, index, item, external, type, 'itemType')"
                class="itemlist">
                <li ng-repeat="item in items"
                    dnd-draggable="item"
                    dnd-type="'itemType'"
                    dnd-effect-allowed="copyMove"
                    dnd-dragstart="logEvent('Started to drag an item', event)"
                    dnd-moved="items.splice($index, 1); logEvent('Item moved', event)"
                    dnd-copied="logEvent('Item copied', event)">
                    {{item.label}}
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>                        
    </div>
</div>