// Constants for model dimensions
export const MODEL_HEIGHT = 80;
export const MODEL_WIDTH = 200;
export const MODEL_RADIUS = 10;

// Constants for header dimensions
export const HEADER_ICON_SIZE = 50;
export const HEADER_HEIGHT = 80;

// Constants for font styling
export const FONT_FAMILY = 'Arial, helvetica, sans-serif';
export const FONT_SIZE_SMALL = 11;
export const FONT_SIZE_BIG = 14;
export const FONT_WEIGHT = 400;

// Constant for line width
export const LINE_WIDTH = 2;

// Constants for colors
export const DARK_COLOR = '#000000';
export const LIGHT_COLOR = '#ffffff';
export const SECONDARY_DARK_COLOR = '#666666';

// Constant for grid size
export const GRID_SIZE = 10

// Constants for list item dimensions and Padding
export const LIST_ITEM_HEIGHT = MODEL_HEIGHT * 0.3;
export const LIST_ITEM_WIDTH = MODEL_WIDTH; //10 is Grid size
export const PADDING_L = GRID_SIZE * 2;
export const PADDING_S = GRID_SIZE;

// Constants for image dimensions
export const IMAGE_WIDTH = MODEL_HEIGHT-10;
export const IMAGE_HEIGHT = MODEL_HEIGHT-10;


/**
 * Parameters for displaying preexisting ports in the map view
  */

const itemAttributes = {
    attrs: {
        portBody: {
            magnet: 'active',
            width: 'calc(w)',
            height: 'calc(h)',
            rx: MODEL_RADIUS * 0.5,
            ry: MODEL_RADIUS * 0.5,
            fill: '#ff00ff',
            stroke: DARK_COLOR,
            strokeWidth: LINE_WIDTH,
        },
        portLabel: {
            pointerEvents: 'none',
            fontFamily: FONT_FAMILY,
            fontWeight: 400,
            fontSize: 13,
            fill: LIGHT_COLOR,
            textAnchor: 'start',
            textVerticalAnchor: 'middle',
            textWrap: {
                width: - PADDING_L - 2 * PADDING_S,
                maxLineCount: 1,
                ellipsis: true
            },
            x: PADDING_L + PADDING_S
        },

    },
    size: {
        width: LIST_ITEM_WIDTH,
        height: LIST_ITEM_HEIGHT
    },
    markup: [{
        tagName: 'rect',
        selector: 'portBody'
    }, {
        tagName: 'text',
        selector: 'portLabel',
    }]
};

/**
 * Class for representing a hardware object in the diagram
 * Reference links:
 * https://codepen.io/jointjs/pen/PodyMbm
 * https://github.com/clientIO/joint/blob/master/demo/list/src/index.ts#L261
 * @returns {{expanded: boolean, size: {width: number, height: number}, position: {x: number, y: number}, type: string, ports: {groups: {USB: {size: {width: number, height: number}, markup: [{selector: string, tagName: string},{selector: string, tagName: string}], attrs: {portBody: {strokeWidth: number, rx, ry, width: string, fill: string, magnet: string, stroke: string, height: string}, portLabel: {fontFamily: string, textVerticalAnchor: string, pointerEvents: string, textWrap: {width, maxLineCount: number, ellipsis: boolean}, x, fontSize: number, fill: string, textAnchor: string, fontWeight: number}}}, Ethernet: {size: {width: number, height: number}, markup: [{selector: string, tagName: string},{selector: string, tagName: string}], attrs: {portBody: {strokeWidth: number, rx, ry, width: string, fill: string, magnet: string, stroke: string, height: string}, portLabel: {fontFamily: string, textVerticalAnchor: string, pointerEvents: string, textWrap: {width, maxLineCount: number, ellipsis: boolean}, x, fontSize: number, fill: string, textAnchor: string, fontWeight: number}}}, Fieldbus: {size: {width: number, height: number}, markup: [{selector: string, tagName: string},{selector: string, tagName: string}], attrs: {portBody: {strokeWidth: number, rx, ry, width: string, fill: string, magnet: string, stroke: string, height: string}, portLabel: {fontFamily: string, textVerticalAnchor: string, pointerEvents: string, textWrap: {width, maxLineCount: number, ellipsis: boolean}, x, fontSize: number, fill: string, textAnchor: string, fontWeight: number}}}}, items: *[]}, attrs: {image: {refX: number, ref: string, refY: number, width: number, "xlink:href": string, height: number}, description: {transform: string, fontFamily: string, textVerticalAnchor: string, textWrap: {width: number, maxLineCount: number, ellipsis: boolean}, fontSize: number, lineHeight: number, text: string, fill: string, fontWeight: number}, label: {transform: string, fontFamily: string, textVerticalAnchor: string, x: number, textWrap: {width: number, maxLineCount: number, ellipsis: boolean}, y: number, fontSize: number, text: string, fill: string, fontWeight: number}, body: {strokeWidth: number, rx: number, ry: number, width: string, fill: string, stroke: string, height: string}}}}
 */
export class HardwareObject extends joint.dia.Element {
    LIST_GROUP_NAME = ['Ethernet', 'USB', 'Fieldbus'];

    defaults() {
        return {
            ...super.defaults,
            type: "HardwareObject",
            expanded: false,
            attrs: {
                // Default attributes body
                body: {
                    width: 'calc(w)',
                    height: 'calc(h)',
                    fill: LIGHT_COLOR,
                    strokeWidth: LINE_WIDTH / 2,
                    stroke: SECONDARY_DARK_COLOR,
                    rx: MODEL_RADIUS,
                    ry: MODEL_RADIUS,
                },
                // Default attributes lable
                label: {
                    transform: `translate(${PADDING_L+IMAGE_WIDTH},${PADDING_L - 5})`,
                    fontFamily: FONT_FAMILY,
                    fontWeight: FONT_WEIGHT * 2,
                    fontSize: FONT_SIZE_BIG,
                    y: -5,
                    x: -PADDING_S,
                    text: 'Placeholder', fill: DARK_COLOR,
                    textWrap: {
                        width: -PADDING_L + 5 - IMAGE_WIDTH,
                        maxLineCount: 1,
                        ellipsis: true
                    },
                    textVerticalAnchor: 'top',
                },
                // Default attributes description
                description: {
                    transform: `translate(${PADDING_L - 8 + IMAGE_WIDTH},${PADDING_L * 1.75})`,
                    fontFamily: FONT_FAMILY,
                    fontWeight: FONT_WEIGHT,
                    fontSize: FONT_SIZE_SMALL,
                    lineHeight: 13,
                    fill: '#0f1b44',
                    textVerticalAnchor: 'top',
                    text: 'Placeholder',
                    textWrap: {
                        width: -PADDING_L - IMAGE_WIDTH,
                        maxLineCount: 2,
                        ellipsis: true
                    }
                },
                // Default attributes image
                image: {
                    "xlink:href" : "../img/unknown.png",
                    refX: 5,
                    refY: 5,
                    ref: 'body',
                    width: IMAGE_WIDTH,
                    height: IMAGE_HEIGHT
                }
            },
            ports: {
                // takes information from the earlyer defined itemAttributes
                groups: {
                    // for each entry in the array there should be a corresponding entry in the markup ???
                    'Ethernet': {
                        ...itemAttributes
                    },
                    'USB': {
                        ...itemAttributes
                    },
                    'Fieldbus': {
                        ...itemAttributes
                    },
                },
                items: [],
            },
            position: {
                x: 0,
                y: 0
            },
            size: {width: MODEL_WIDTH, height: MODEL_HEIGHT}
        };
    }

    /**
     * Initialize the markup structure for the hardware object
     */
    preinitialize() {
        this.markup = [{
            tagName: 'rect',
            selector: 'body',
        }, {
            tagName: 'text',
            selector: 'label',
        }, {
            tagName: 'text',
            selector: 'description',
        }, {
            tagName: 'image',
            selector: 'xlink:href',
        }];
    }

    constructor(...args) {
        super(...args);
    }

    /**
     * Add a number of ports to the scoped hardware object of the chosen type and color.
     *
     * @param portCount
     * @param portColor
     * @param portGroup
     */
    addDefaultPort(portCount, portColor, portGroup) {
        this.addPort({
            args: {
                y: MODEL_HEIGHT + portCount * (LIST_ITEM_HEIGHT),
            },
            attrs: {
                portBody: {
                    magnet: 'active',
                    fill: portColor,
                    width: 'calc(w)',
                    height: 'calc(h)',
                    rx: MODEL_RADIUS * 0.5,
                    ry: MODEL_RADIUS * 0.5,
                    stroke: DARK_COLOR,
                    strokeWidth: LINE_WIDTH
                },
            },
            markup: [{
                tagName: 'rect',
                selector: 'portBody'
            }],
            group: portGroup,
        });
    }
}

/**
 * Create a new hardware object node or "cell" without any ports. Must be added to the current graph to persist. Ports may be added by calling addDefaultPort() post creation.
 *
 * @param description
 * @param name
 * @param icon
 * @param settings
 * @param device_id
 * @param type
 * @returns {HardwareObject}
 */
export function createNewDefaultElement(description, name, icon, settings, device_id, type) {
    return new HardwareObject({
        attrs: {
            settings: settings,
            description: {
                text: (description == null || description == "null") ? ' ':description,
            },
            label: {
                text: name,
            },
            icon: {
                xlinkHref: icon,
            },
            device_id: {
                text: device_id,
            },
            image: {
                "xlink:href" : "../img/"+type,
            }
        },
    });
}

// Namespace for joint shapes and the hardware object class
export let namespace = {
    ...joint.shapes,
    HardwareObject
};

// Create graph and paper to be used in map.blade.php to display the map
export let graph = new joint.dia.Graph({}, {cellNamespace: namespace});
export let paper = new joint.dia.Paper({
    el: document.getElementById('myholder'),
    width: '100%',
    height: '100%',
    gridSize: GRID_SIZE,
    model: graph,
    cellViewNamespace: namespace,
    restrictTranslate: true,
    drawGrid: true,
    moveThreshold: 5,
    background: {
        color: '#f8f9fa'
    },
    linkPinning: false, // Prevent link being dropped in blank paper area
    defaultLink: function (elementJointJSView, magnetDOMElement) {

        let lineColour = magnetDOMElement.getAttribute('fill');
        let labelText = magnetDOMElement.getAttribute('port-group');

        let curLink = new joint.shapes.standard.Link({
            router: {name: 'manhattan'},
            connector: {name: 'rounded'},
            attrs: {
                wrapper: {
                    cursor: 'default',
                },
                line: {
                    stroke: lineColour,
                    strokeWidth: 1,
                    sourceMarker: {
                        'type': 'circle',
                        'r': 4,
                        'stroke': 'black',
                        'fill': lineColour,
                    },
                    targetMarker: {
                        'type': 'circle',
                        'r': 4,
                        'stroke': 'black',
                        'fill': lineColour,
                    }
                }
            },
        });
        curLink.appendLabel({
            attrs: {
                text: {
                    text: labelText,
                    fontVariant: 'small-caps',
                    fontSize: 18,
                },
            }
        });
        return curLink;

    },
    defaultConnectionPoint: {name: 'boundary'},

    /**
     * Restrict elements from linking to themselves, to already occupied ports or between ports of different types
     */
    validateConnection: function (cellViewS, magnetS, cellViewT, magnetT, end, linkView) {


        // Prevent linking from output ports to input ports within one element
        if (cellViewS === cellViewT) return false;
        if(magnetS === undefined || magnetT === undefined || magnetT === null || magnetS === null) return false;

        // Check if target port is already occupied
        var links = graph.getConnectedLinks(cellViewT.model);
        let linkExists;
        links.forEach((link) => {
           if (link.get('target').port === magnetT.getAttribute('port') || link.get('source').port === magnetT.getAttribute('port')) linkExists = true;
        });


        if (linkExists) return false;


        // Prevent linking to different type of ports
        return magnetT && magnetS.getAttribute('port-group') === magnetT.getAttribute('port-group');



    },
    /**
    * Validate that there are no outgoing connections from the current port or "magnet" and the magnet is not set to passive (default behavior)
     */
    validateMagnet: function (cellView, magnet) {
        //Check if source port already occupied
        var port = magnet.getAttribute('port');
        var links = graph.getConnectedLinks(cellView.model);

        let linkExists;
        links.forEach((link) => {
            if (link.get('source').port === port || link.get('target').port === port) linkExists = true;
        });
        if (linkExists) return false;


        // Note that this is the default behaviour. It is shown for reference purposes.
        // Disable linking interaction for magnets marked as passive
        return magnet.getAttribute('magnet') !== 'passive';
    },
    // Enable link snapping within 20px lookup radius
    snapLinks: {radius: MODEL_RADIUS},
    // Enable mark available for cells & magnets
    markAvailable: true,
    highlighting: {
        'magnetAvailability': {
            name: 'addClass',
            options: {
                className: 'custom-available-magnet'
            }
        },
        'elementAvailability': {
            name: 'stroke',
            options: {
                padding: PADDING_L,
                attrs: {
                    'stroke-width': 3,
                    'stroke': '#ED6A5A'
                }
            }
        }
    }
});

/**
 * Function to show link tools for editing and removing links
 *
 * @param linkView
 */
export function showLinkTools(linkView) {
    var tools = new joint.dia.ToolsView({
        tools: [
            new joint.linkTools.Remove({
                distance: '50%',
                markup: [{
                    tagName: 'circle',
                    selector: 'button',
                    attributes: {
                        'r': 7,
                        'fill': '#f6f6f6',
                        'stroke': '#ff5148',
                        'stroke-width': 2,
                        'cursor': 'pointer'
                    }
                }, {
                    tagName: 'path',
                    selector: 'icon',
                    attributes: {
                        'd': 'M -3 -3 3 3 M -3 3 3 -3',
                        'fill': 'none',
                        'stroke': '#ff5148',
                        'stroke-width': 2,
                        'pointer-events': 'none'
                    }
                }]
            })
        ]
    });
    linkView.addTools(tools);
}

/**
 * Add custom styles to the paper's SVG element
 */
paper.svg.prepend(
    joint.V.createSVGStyle(`
        .joint-element .selection~.joint-port, .joint-element .selection{
            stroke: #ff5148;
            stroke-dasharray: 5;
            stroke-dashoffset: 10;
            animation: dash 0.5s infinite linear;
        }
        @keyframes dash {
            to {
                stroke-dashoffset: 0;
            }
        }
    `)
);
