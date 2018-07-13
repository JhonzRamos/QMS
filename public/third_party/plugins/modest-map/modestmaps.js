var previousMM = MM;
if (!com) {
    var com = {};
    if (!com.modestmaps) com.modestmaps = {}
}
var MM = com.modestmaps = {
    noConflict: function() {
        MM = previousMM;
        return this
    }
};
(function(MM) {
    MM.extend = function(child, parent) {
        for (var property in parent.prototype) {
            if (typeof child.prototype[property] == "undefined") {
                child.prototype[property] = parent.prototype[property]
            }
        }
        return child
    };
    MM.getFrame = function() {
        return function(callback) {
            (window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(callback) {
                window.setTimeout(function() {
                    callback(+new Date)
                }, 10)
            })(callback)
        }
    }();
    MM.transformProperty = function(props) {
        if (!this.document) return;
        var style = document.documentElement.style;
        for (var i = 0; i < props.length; i++) {
            if (props[i] in style) {
                return props[i]
            }
        }
        return false
    }(["transform", "WebkitTransform", "OTransform", "MozTransform", "msTransform"]);
    MM.matrixString = function(point) {
        if (point.scale * point.width % 1) {
            point.scale += (1 - point.scale * point.width % 1) / point.width
        }
        var scale = point.scale || 1;
        if (MM._browser.webkit3d) {
            return "translate3d(" + point.x.toFixed(0) + "px," + point.y.toFixed(0) + "px, 0px)" + "scale3d(" + scale + "," + scale + ", 1)"
        } else {
            return "translate(" + point.x.toFixed(6) + "px," + point.y.toFixed(6) + "px)" + "scale(" + scale + "," + scale + ")"
        }
    };
    MM._browser = function(window) {
        return {
            webkit: "WebKitCSSMatrix" in window,
            webkit3d: "WebKitCSSMatrix" in window && "m11" in new WebKitCSSMatrix
        }
    }(this);
    MM.moveElement = function(el, point) {
        if (MM.transformProperty) {
            if (!point.scale) point.scale = 1;
            if (!point.width) point.width = 0;
            if (!point.height) point.height = 0;
            var ms = MM.matrixString(point);
            if (el[MM.transformProperty] !== ms) {
                el.style[MM.transformProperty] = el[MM.transformProperty] = ms
            }
        } else {
            el.style.left = point.x + "px";
            el.style.top = point.y + "px";
            if (point.width && point.height && point.scale) {
                el.style.width = Math.ceil(point.width * point.scale) + "px";
                el.style.height = Math.ceil(point.height * point.scale) + "px"
            }
        }
    };
    MM.cancelEvent = function(e) {
        e.cancelBubble = true;
        e.cancel = true;
        e.returnValue = false;
        if (e.stopPropagation) {
            e.stopPropagation()
        }
        if (e.preventDefault) {
            e.preventDefault()
        }
        return false
    };
    MM.coerceLayer = function(layerish) {
        if (typeof layerish == "string") {
            return new MM.Layer(new MM.TemplatedLayer(layerish))
        } else if ("draw" in layerish && typeof layerish.draw == "function") {
            return layerish
        } else {
            return new MM.Layer(layerish)
        }
    };
    MM.addEvent = function(obj, type, fn) {
        if (obj.addEventListener) {
            obj.addEventListener(type, fn, false);
            if (type == "mousewheel") {
                obj.addEventListener("DOMMouseScroll", fn, false)
            }
        } else if (obj.attachEvent) {
            obj["e" + type + fn] = fn;
            obj[type + fn] = function() {
                obj["e" + type + fn](window.event)
            };
            obj.attachEvent("on" + type, obj[type + fn])
        }
    };
    MM.removeEvent = function(obj, type, fn) {
        if (obj.removeEventListener) {
            obj.removeEventListener(type, fn, false);
            if (type == "mousewheel") {
                obj.removeEventListener("DOMMouseScroll", fn, false)
            }
        } else if (obj.detachEvent) {
            obj.detachEvent("on" + type, obj[type + fn]);
            obj[type + fn] = null
        }
    };
    MM.getStyle = function(el, styleProp) {
        if (el.currentStyle) return el.currentStyle[styleProp];
        else if (window.getComputedStyle) return document.defaultView.getComputedStyle(el, null).getPropertyValue(styleProp)
    };
    MM.Point = function(x, y) {
        this.x = parseFloat(x);
        this.y = parseFloat(y)
    };
    MM.Point.prototype = {
        x: 0,
        y: 0,
        toString: function() {
            return "(" + this.x.toFixed(3) + ", " + this.y.toFixed(3) + ")"
        },
        copy: function() {
            return new MM.Point(this.x, this.y)
        }
    };
    MM.Point.distance = function(p1, p2) {
        return Math.sqrt(Math.pow(p2.x - p1.x, 2) + Math.pow(p2.y - p1.y, 2))
    };
    MM.Point.interpolate = function(p1, p2, t) {
        return new MM.Point(p1.x + (p2.x - p1.x) * t, p1.y + (p2.y - p1.y) * t)
    };
    MM.Coordinate = function(row, column, zoom) {
        this.row = row;
        this.column = column;
        this.zoom = zoom
    };
    MM.Coordinate.prototype = {
        row: 0,
        column: 0,
        zoom: 0,
        toString: function() {
            return "(" + this.row.toFixed(3) + ", " + this.column.toFixed(3) + " @" + this.zoom.toFixed(3) + ")"
        },
        toKey: function() {
            return this.zoom + "," + this.row + "," + this.column
        },
        copy: function() {
            return new MM.Coordinate(this.row, this.column, this.zoom)
        },
        container: function() {
            return new MM.Coordinate(Math.floor(this.row), Math.floor(this.column), Math.floor(this.zoom))
        },
        zoomTo: function(destination) {
            var power = Math.pow(2, destination - this.zoom);
            return new MM.Coordinate(this.row * power, this.column * power, destination)
        },
        zoomBy: function(distance) {
            var power = Math.pow(2, distance);
            return new MM.Coordinate(this.row * power, this.column * power, this.zoom + distance)
        },
        up: function(dist) {
            if (dist === undefined) dist = 1;
            return new MM.Coordinate(this.row - dist, this.column, this.zoom)
        },
        right: function(dist) {
            if (dist === undefined) dist = 1;
            return new MM.Coordinate(this.row, this.column + dist, this.zoom)
        },
        down: function(dist) {
            if (dist === undefined) dist = 1;
            return new MM.Coordinate(this.row + dist, this.column, this.zoom)
        },
        left: function(dist) {
            if (dist === undefined) dist = 1;
            return new MM.Coordinate(this.row, this.column - dist, this.zoom)
        }
    };
    MM.Location = function(lat, lon) {
        this.lat = parseFloat(lat);
        this.lon = parseFloat(lon)
    };
    MM.Location.prototype = {
        lat: 0,
        lon: 0,
        toString: function() {
            return "(" + this.lat.toFixed(3) + ", " + this.lon.toFixed(3) + ")"
        },
        copy: function() {
            return new MM.Location(this.lat, this.lon)
        }
    };
    MM.Location.distance = function(l1, l2, r) {
        if (!r) {
            r = 6378e3
        }
        var deg2rad = Math.PI / 180,
            a1 = l1.lat * deg2rad,
            b1 = l1.lon * deg2rad,
            a2 = l2.lat * deg2rad,
            b2 = l2.lon * deg2rad,
            c = Math.cos(a1) * Math.cos(b1) * Math.cos(a2) * Math.cos(b2),
            d = Math.cos(a1) * Math.sin(b1) * Math.cos(a2) * Math.sin(b2),
            e = Math.sin(a1) * Math.sin(a2);
        return Math.acos(c + d + e) * r
    };
    MM.Location.interpolate = function(l1, l2, f) {
        if (l1.lat === l2.lat && l1.lon === l2.lon) {
            return new MM.Location(l1.lat, l1.lon)
        }
        var deg2rad = Math.PI / 180,
            lat1 = l1.lat * deg2rad,
            lon1 = l1.lon * deg2rad,
            lat2 = l2.lat * deg2rad,
            lon2 = l2.lon * deg2rad;
        var d = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin((lat1 - lat2) * .5), 2) + Math.cos(lat1) * Math.cos(lat2) * Math.pow(Math.sin((lon1 - lon2) * .5), 2)));
        var A = Math.sin((1 - f) * d) / Math.sin(d);
        var B = Math.sin(f * d) / Math.sin(d);
        var x = A * Math.cos(lat1) * Math.cos(lon1) + B * Math.cos(lat2) * Math.cos(lon2);
        var y = A * Math.cos(lat1) * Math.sin(lon1) + B * Math.cos(lat2) * Math.sin(lon2);
        var z = A * Math.sin(lat1) + B * Math.sin(lat2);
        var latN = Math.atan2(z, Math.sqrt(Math.pow(x, 2) + Math.pow(y, 2)));
        var lonN = Math.atan2(y, x);
        return new MM.Location(latN / deg2rad, lonN / deg2rad)
    };
    MM.Location.bearing = function(l1, l2) {
        var deg2rad = Math.PI / 180,
            lat1 = l1.lat * deg2rad,
            lon1 = l1.lon * deg2rad,
            lat2 = l2.lat * deg2rad,
            lon2 = l2.lon * deg2rad;
        var result = Math.atan2(Math.sin(lon1 - lon2) * Math.cos(lat2), Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1) * Math.cos(lat2) * Math.cos(lon1 - lon2)) / -(Math.PI / 180);
        return result < 0 ? result + 360 : result
    };
    MM.Extent = function(north, west, south, east) {
        if (north instanceof MM.Location && west instanceof MM.Location) {
            var northwest = north,
                southeast = west;
            north = northwest.lat;
            west = northwest.lon;
            south = southeast.lat;
            east = southeast.lon
        }
        if (isNaN(south)) south = north;
        if (isNaN(east)) east = west;
        this.north = Math.max(north, south);
        this.south = Math.min(north, south);
        this.east = Math.max(east, west);
        this.west = Math.min(east, west)
    };
    MM.Extent.prototype = {
        north: 0,
        south: 0,
        east: 0,
        west: 0,
        copy: function() {
            return new MM.Extent(this.north, this.west, this.south, this.east)
        },
        toString: function(precision) {
            if (isNaN(precision)) precision = 3;
            return [this.north.toFixed(precision), this.west.toFixed(precision), this.south.toFixed(precision), this.east.toFixed(precision)].join(", ")
        },
        northWest: function() {
            return new MM.Location(this.north, this.west)
        },
        southEast: function() {
            return new MM.Location(this.south, this.east)
        },
        northEast: function() {
            return new MM.Location(this.north, this.east)
        },
        southWest: function() {
            return new MM.Location(this.south, this.west)
        },
        center: function() {
            return new MM.Location(this.south + (this.north - this.south) * .5, this.east + (this.west - this.east) * .5)
        },
        encloseLocation: function(loc) {
            if (loc.lat > this.north) this.north = loc.lat;
            if (loc.lat < this.south) this.south = loc.lat;
            if (loc.lon > this.east) this.east = loc.lon;
            if (loc.lon < this.west) this.west = loc.lon
        },
        encloseLocations: function(locations) {
            var len = locations.length;
            for (var i = 0; i < len; i++) {
                this.encloseLocation(locations[i])
            }
        },
        setFromLocations: function(locations) {
            var len = locations.length,
                first = locations[0];
            this.north = this.south = first.lat;
            this.east = this.west = first.lon;
            for (var i = 1; i < len; i++) {
                this.encloseLocation(locations[i])
            }
        },
        encloseExtent: function(extent) {
            if (extent.north > this.north) this.north = extent.north;
            if (extent.south < this.south) this.south = extent.south;
            if (extent.east > this.east) this.east = extent.east;
            if (extent.west < this.west) this.west = extent.west
        },
        containsLocation: function(loc) {
            return loc.lat >= this.south && loc.lat <= this.north && loc.lon >= this.west && loc.lon <= this.east
        },
        toArray: function() {
            return [this.northWest(), this.southEast()]
        }
    };
    MM.Extent.fromString = function(str) {
        var parts = str.split(/\s*,\s*/);
        if (parts.length != 4) {
            throw "Invalid extent string (expecting 4 comma-separated numbers)"
        }
        return new MM.Extent(parseFloat(parts[0]), parseFloat(parts[1]), parseFloat(parts[2]), parseFloat(parts[3]))
    };
    MM.Extent.fromArray = function(locations) {
        var extent = new MM.Extent;
        extent.setFromLocations(locations);
        return extent
    };
    MM.Transformation = function(ax, bx, cx, ay, by, cy) {
        this.ax = ax;
        this.bx = bx;
        this.cx = cx;
        this.ay = ay;
        this.by = by;
        this.cy = cy
    };
    MM.Transformation.prototype = {
        ax: 0,
        bx: 0,
        cx: 0,
        ay: 0,
        by: 0,
        cy: 0,
        transform: function(point) {
            return new MM.Point(this.ax * point.x + this.bx * point.y + this.cx, this.ay * point.x + this.by * point.y + this.cy)
        },
        untransform: function(point) {
            return new MM.Point((point.x * this.by - point.y * this.bx - this.cx * this.by + this.cy * this.bx) / (this.ax * this.by - this.ay * this.bx), (point.x * this.ay - point.y * this.ax - this.cx * this.ay + this.cy * this.ax) / (this.bx * this.ay - this.by * this.ax))
        }
    };
    MM.deriveTransformation = function(a1x, a1y, a2x, a2y, b1x, b1y, b2x, b2y, c1x, c1y, c2x, c2y) {
        var x = MM.linearSolution(a1x, a1y, a2x, b1x, b1y, b2x, c1x, c1y, c2x);
        var y = MM.linearSolution(a1x, a1y, a2y, b1x, b1y, b2y, c1x, c1y, c2y);
        return new MM.Transformation(x[0], x[1], x[2], y[0], y[1], y[2])
    };
    MM.linearSolution = function(r1, s1, t1, r2, s2, t2, r3, s3, t3) {
        r1 = parseFloat(r1);
        s1 = parseFloat(s1);
        t1 = parseFloat(t1);
        r2 = parseFloat(r2);
        s2 = parseFloat(s2);
        t2 = parseFloat(t2);
        r3 = parseFloat(r3);
        s3 = parseFloat(s3);
        t3 = parseFloat(t3);
        var a = ((t2 - t3) * (s1 - s2) - (t1 - t2) * (s2 - s3)) / ((r2 - r3) * (s1 - s2) - (r1 - r2) * (s2 - s3));
        var b = ((t2 - t3) * (r1 - r2) - (t1 - t2) * (r2 - r3)) / ((s2 - s3) * (r1 - r2) - (s1 - s2) * (r2 - r3));
        var c = t1 - r1 * a - s1 * b;
        return [a, b, c]
    };
    MM.Projection = function(zoom, transformation) {
        if (!transformation) {
            transformation = new MM.Transformation(1, 0, 0, 0, 1, 0)
        }
        this.zoom = zoom;
        this.transformation = transformation
    };
    MM.Projection.prototype = {
        zoom: 0,
        transformation: null,
        rawProject: function(point) {
            throw "Abstract method not implemented by subclass."
        },
        rawUnproject: function(point) {
            throw "Abstract method not implemented by subclass."
        },
        project: function(point) {
            point = this.rawProject(point);
            if (this.transformation) {
                point = this.transformation.transform(point)
            }
            return point
        },
        unproject: function(point) {
            if (this.transformation) {
                point = this.transformation.untransform(point)
            }
            point = this.rawUnproject(point);
            return point
        },
        locationCoordinate: function(location) {
            var point = new MM.Point(Math.PI * location.lon / 180, Math.PI * location.lat / 180);
            point = this.project(point);
            return new MM.Coordinate(point.y, point.x, this.zoom)
        },
        coordinateLocation: function(coordinate) {
            coordinate = coordinate.zoomTo(this.zoom);
            var point = new MM.Point(coordinate.column, coordinate.row);
            point = this.unproject(point);
            return new MM.Location(180 * point.y / Math.PI, 180 * point.x / Math.PI)
        }
    };
    MM.LinearProjection = function(zoom, transformation) {
        MM.Projection.call(this, zoom, transformation)
    };
    MM.LinearProjection.prototype = {
        rawProject: function(point) {
            return new MM.Point(point.x, point.y)
        },
        rawUnproject: function(point) {
            return new MM.Point(point.x, point.y)
        }
    };
    MM.extend(MM.LinearProjection, MM.Projection);
    MM.MercatorProjection = function(zoom, transformation) {
        MM.Projection.call(this, zoom, transformation)
    };
    MM.MercatorProjection.prototype = {
        rawProject: function(point) {
            return new MM.Point(point.x, Math.log(Math.tan(.25 * Math.PI + .5 * point.y)))
        },
        rawUnproject: function(point) {
            return new MM.Point(point.x, 2 * Math.atan(Math.pow(Math.E, point.y)) - .5 * Math.PI)
        }
    };
    MM.extend(MM.MercatorProjection, MM.Projection);
    MM.MapProvider = function(getTile) {
        if (getTile) {
            this.getTile = getTile
        }
    };
    MM.MapProvider.prototype = {
        tileLimits: [new MM.Coordinate(0, 0, 0), new MM.Coordinate(1, 1, 0).zoomTo(18)],
        getTileUrl: function(coordinate) {
            throw "Abstract method not implemented by subclass."
        },
        getTile: function(coordinate) {
            throw "Abstract method not implemented by subclass."
        },
        releaseTile: function(element) {},
        setZoomRange: function(minZoom, maxZoom) {
            this.tileLimits[0] = this.tileLimits[0].zoomTo(minZoom);
            this.tileLimits[1] = this.tileLimits[1].zoomTo(maxZoom)
        },
        sourceCoordinate: function(coord) {
            var TL = this.tileLimits[0].zoomTo(coord.zoom).container(),
                BR = this.tileLimits[1].zoomTo(coord.zoom),
                columnSize = Math.pow(2, coord.zoom),
                wrappedColumn;
            BR = new MM.Coordinate(Math.ceil(BR.row), Math.ceil(BR.column), Math.floor(BR.zoom));
            if (coord.column < 0) {
                wrappedColumn = (coord.column % columnSize + columnSize) % columnSize
            } else {
                wrappedColumn = coord.column % columnSize
            } if (coord.row < TL.row || coord.row >= BR.row) {
                return null
            } else if (wrappedColumn < TL.column || wrappedColumn >= BR.column) {
                return null
            } else {
                return new MM.Coordinate(coord.row, wrappedColumn, coord.zoom)
            }
        }
    };
    MM.Template = function(template, subdomains) {
        var isQuadKey = template.match(/{(Q|quadkey)}/);
        if (isQuadKey) template = template.replace("{subdomain}", "{S}").replace("{zoom}", "{Z}").replace("{quadkey}", "{Q}");
        var hasSubdomains = subdomains && subdomains.length && template.indexOf("{S}") >= 0;

        function quadKey(row, column, zoom) {
            var key = "";
            for (var i = 1; i <= zoom; i++) {
                key += (row >> zoom - i & 1) << 1 | column >> zoom - i & 1
            }
            return key || "0"
        }
        var getTileUrl = function(coordinate) {
            var coord = this.sourceCoordinate(coordinate);
            if (!coord) {
                return null
            }
            var base = template;
            if (hasSubdomains) {
                var index = parseInt(coord.zoom + coord.row + coord.column, 10) % subdomains.length;
                base = base.replace("{S}", subdomains[index])
            }
            if (isQuadKey) {
                return base.replace("{Z}", coord.zoom.toFixed(0)).replace("{Q}", quadKey(coord.row, coord.column, coord.zoom))
            } else {
                return base.replace("{Z}", coord.zoom.toFixed(0)).replace("{X}", coord.column.toFixed(0)).replace("{Y}", coord.row.toFixed(0))
            }
        };
        MM.MapProvider.call(this, getTileUrl)
    };
    MM.Template.prototype = {
        getTile: function(coord) {
            return this.getTileUrl(coord)
        }
    };
    MM.extend(MM.Template, MM.MapProvider);
    MM.TemplatedLayer = function(template, subdomains, name) {
        return new MM.Layer(new MM.Template(template, subdomains), null, name)
    };
    MM.getMousePoint = function(e, map) {
        var point = new MM.Point(e.clientX, e.clientY);
        point.x += document.body.scrollLeft + document.documentElement.scrollLeft;
        point.y += document.body.scrollTop + document.documentElement.scrollTop;
        for (var node = map.parent; node; node = node.offsetParent) {
            point.x -= node.offsetLeft;
            point.y -= node.offsetTop
        }
        return point
    };
    MM.MouseWheelHandler = function() {
        var handler = {
            id: "MouseWheelHandler"
        }, map, _zoomDiv, prevTime, precise = false;

        function mouseWheel(e) {
            var delta = 0;
            prevTime = prevTime || (new Date).getTime();
            try {
                _zoomDiv.scrollTop = 1e3;
                _zoomDiv.dispatchEvent(e);
                delta = 1e3 - _zoomDiv.scrollTop
            } catch (error) {
                delta = e.wheelDelta || -e.detail * 5
            }
            var timeSince = (new Date).getTime() - prevTime;
            var point = MM.getMousePoint(e, map);
            if (Math.abs(delta) > 0 && timeSince > 200 && !precise) {
                map.zoomByAbout(delta > 0 ? 1 : -1, point);
                prevTime = (new Date).getTime()
            } else if (precise) {
                map.zoomByAbout(delta * .001, point)
            }
            return MM.cancelEvent(e)
        }
        handler.init = function(x) {
            map = x;
            _zoomDiv = document.body.appendChild(document.createElement("div"));
            _zoomDiv.style.cssText = "visibility:hidden;top:0;height:0;width:0;overflow-y:scroll";
            var innerDiv = _zoomDiv.appendChild(document.createElement("div"));
            innerDiv.style.height = "2000px";
            MM.addEvent(map.parent, "mousewheel", mouseWheel);
            return handler
        };
        handler.precise = function(x) {
            if (!arguments.length) return precise;
            precise = x;
            return handler
        };
        handler.remove = function() {
            MM.removeEvent(map.parent, "mousewheel", mouseWheel);
            _zoomDiv.parentNode.removeChild(_zoomDiv)
        };
        return handler
    };
    MM.DoubleClickHandler = function() {
        var handler = {
            id: "DoubleClickHandler"
        }, map;

        function doubleClick(e) {
            var point = MM.getMousePoint(e, map);
            map.zoomByAbout(e.shiftKey ? -1 : 1, point);
            return MM.cancelEvent(e)
        }
        handler.init = function(x) {
            map = x;
            MM.addEvent(map.parent, "dblclick", doubleClick);
            return handler
        };
        handler.remove = function() {
            MM.removeEvent(map.parent, "dblclick", doubleClick)
        };
        return handler
    };
    MM.DragHandler = function() {
        var handler = {
            id: "DragHandler"
        }, prevMouse, map;

        function mouseDown(e) {
            if (e.shiftKey || e.button == 2) return;
            MM.addEvent(document, "mouseup", mouseUp);
            MM.addEvent(document, "mousemove", mouseMove);
            prevMouse = new MM.Point(e.clientX, e.clientY);
            map.parent.style.cursor = "move";
            return MM.cancelEvent(e)
        }

        function mouseUp(e) {
            MM.removeEvent(document, "mouseup", mouseUp);
            MM.removeEvent(document, "mousemove", mouseMove);
            prevMouse = null;
            map.parent.style.cursor = "";
            return MM.cancelEvent(e)
        }

        function mouseMove(e) {
            if (prevMouse) {
                map.panBy(e.clientX - prevMouse.x, e.clientY - prevMouse.y);
                prevMouse.x = e.clientX;
                prevMouse.y = e.clientY;
                prevMouse.t = +new Date
            }
            return MM.cancelEvent(e)
        }
        handler.init = function(x) {
            map = x;
            MM.addEvent(map.parent, "mousedown", mouseDown);
            return handler
        };
        handler.remove = function() {
            MM.removeEvent(map.parent, "mousedown", mouseDown)
        };
        return handler
    };
    MM.MouseHandler = function() {
        var handler = {
            id: "MouseHandler",
            handlers: []
        }, map;
        handler.init = function(x) {
            map = x;
            handler.handlers = [MM.DragHandler().init(map), MM.DoubleClickHandler().init(map), MM.MouseWheelHandler().init(map)];
            return handler
        };
        handler.remove = function() {
            for (var i = 0; i < handler.handlers.length; i++) {
                handler.handlers[i].remove()
            }
            handler.handlers = [];
            return handler
        };
        return handler
    };
    MM.TouchHandler = function() {
        var handler = {
            id: "TouchHandler"
        }, map, maxTapTime = 250,
            maxTapDistance = 30,
            maxDoubleTapDelay = 350,
            locations = {}, taps = [],
            snapToZoom = true,
            wasPinching = false,
            lastPinchCenter = null;

        function isTouchable() {
            var el = document.createElement("div");
            el.setAttribute("ongesturestart", "return;");
            return typeof el.ongesturestart === "function"
        }

        function updateTouches(e) {
            for (var i = 0; i < e.touches.length; i += 1) {
                var t = e.touches[i];
                if (t.identifier in locations) {
                    var l = locations[t.identifier];
                    l.x = t.clientX;
                    l.y = t.clientY;
                    l.scale = e.scale
                } else {
                    locations[t.identifier] = {
                        scale: e.scale,
                        startPos: {
                            x: t.clientX,
                            y: t.clientY
                        },
                        x: t.clientX,
                        y: t.clientY,
                        time: (new Date).getTime()
                    }
                }
            }
        }

        function sameTouch(event, touch) {
            return event && event.touch && touch.identifier == event.touch.identifier
        }

        function touchStart(e) {
            updateTouches(e)
        }

        function touchMove(e) {
            switch (e.touches.length) {
                case 1:
                    onPanning(e.touches[0]);
                    break;
                case 2:
                    onPinching(e);
                    break
            }
            updateTouches(e);
            return MM.cancelEvent(e)
        }

        function touchEnd(e) {
            var now = (new Date).getTime();
            if (e.touches.length === 0 && wasPinching) {
                onPinched(lastPinchCenter)
            }
            for (var i = 0; i < e.changedTouches.length; i += 1) {
                var t = e.changedTouches[i],
                    loc = locations[t.identifier];
                if (!loc || loc.wasPinch) {
                    continue
                }
                var pos = {
                    x: t.clientX,
                    y: t.clientY
                }, time = now - loc.time,
                    travel = MM.Point.distance(pos, loc.startPos);
                if (travel > maxTapDistance) {} else if (time > maxTapTime) {
                    pos.end = now;
                    pos.duration = time;
                    onHold(pos)
                } else {
                    pos.time = now;
                    onTap(pos)
                }
            }
            var validTouchIds = {};
            for (var j = 0; j < e.touches.length; j++) {
                validTouchIds[e.touches[j].identifier] = true
            }
            for (var id in locations) {
                if (!(id in validTouchIds)) {
                    delete validTouchIds[id]
                }
            }
            return MM.cancelEvent(e)
        }

        function onHold(hold) {}

        function onTap(tap) {
            if (taps.length && tap.time - taps[0].time < maxDoubleTapDelay) {
                onDoubleTap(tap);
                taps = [];
                return
            }
            taps = [tap]
        }

        function onDoubleTap(tap) {
            var z = map.getZoom(),
                tz = Math.round(z) + 1,
                dz = tz - z;
            var p = new MM.Point(tap.x, tap.y);
            map.zoomByAbout(dz, p)
        }

        function onPanning(touch) {
            var pos = {
                x: touch.clientX,
                y: touch.clientY
            }, prev = locations[touch.identifier];
            map.panBy(pos.x - prev.x, pos.y - prev.y)
        }

        function onPinching(e) {
            var t0 = e.touches[0],
                t1 = e.touches[1],
                p0 = new MM.Point(t0.clientX, t0.clientY),
                p1 = new MM.Point(t1.clientX, t1.clientY),
                l0 = locations[t0.identifier],
                l1 = locations[t1.identifier];
            l0.wasPinch = true;
            l1.wasPinch = true;
            var center = MM.Point.interpolate(p0, p1, .5);
            map.zoomByAbout(Math.log(e.scale) / Math.LN2 - Math.log(l0.scale) / Math.LN2, center);
            var prevCenter = MM.Point.interpolate(l0, l1, .5);
            map.panBy(center.x - prevCenter.x, center.y - prevCenter.y);
            wasPinching = true;
            lastPinchCenter = center
        }

        function onPinched(p) {
            if (snapToZoom) {
                var z = map.getZoom(),
                    tz = Math.round(z);
                map.zoomByAbout(tz - z, p)
            }
            wasPinching = false
        }
        handler.init = function(x) {
            map = x;
            if (!isTouchable()) return handler;
            MM.addEvent(map.parent, "touchstart", touchStart);
            MM.addEvent(map.parent, "touchmove", touchMove);
            MM.addEvent(map.parent, "touchend", touchEnd);
            return handler
        };
        handler.remove = function() {
            if (!isTouchable()) return handler;
            MM.removeEvent(map.parent, "touchstart", touchStart);
            MM.removeEvent(map.parent, "touchmove", touchMove);
            MM.removeEvent(map.parent, "touchend", touchEnd);
            return handler
        };
        return handler
    };
    MM.CallbackManager = function(owner, events) {
        this.owner = owner;
        this.callbacks = {};
        for (var i = 0; i < events.length; i++) {
            this.callbacks[events[i]] = []
        }
    };
    MM.CallbackManager.prototype = {
        owner: null,
        callbacks: null,
        addCallback: function(event, callback) {
            if (typeof callback == "function" && this.callbacks[event]) {
                this.callbacks[event].push(callback)
            }
        },
        removeCallback: function(event, callback) {
            if (typeof callback == "function" && this.callbacks[event]) {
                var cbs = this.callbacks[event],
                    len = cbs.length;
                for (var i = 0; i < len; i++) {
                    if (cbs[i] === callback) {
                        cbs.splice(i, 1);
                        break
                    }
                }
            }
        },
        dispatchCallback: function(event, message) {
            if (this.callbacks[event]) {
                for (var i = 0; i < this.callbacks[event].length; i += 1) {
                    try {
                        this.callbacks[event][i](this.owner, message)
                    } catch (e) {}
                }
            }
        }
    };
    MM.RequestManager = function() {
        this.loadingBay = document.createDocumentFragment();
        this.requestsById = {};
        this.openRequestCount = 0;
        this.maxOpenRequests = 4;
        this.requestQueue = [];
        this.callbackManager = new MM.CallbackManager(this, ["requestcomplete", "requesterror"])
    };
    MM.RequestManager.prototype = {
        loadingBay: null,
        requestsById: null,
        requestQueue: null,
        openRequestCount: null,
        maxOpenRequests: null,
        callbackManager: null,
        addCallback: function(event, callback) {
            this.callbackManager.addCallback(event, callback)
        },
        removeCallback: function(event, callback) {
            this.callbackManager.removeCallback(event, callback)
        },
        dispatchCallback: function(event, message) {
            this.callbackManager.dispatchCallback(event, message)
        },
        clear: function() {
            this.clearExcept({})
        },
        clearRequest: function(id) {
            if (id in this.requestsById) {
                delete this.requestsById[id]
            }
            for (var i = 0; i < this.requestQueue.length; i++) {
                var request = this.requestQueue[i];
                if (request && request.id == id) {
                    this.requestQueue[i] = null
                }
            }
        },
        clearExcept: function(validIds) {
            for (var i = 0; i < this.requestQueue.length; i++) {
                var request = this.requestQueue[i];
                if (request && !(request.id in validIds)) {
                    this.requestQueue[i] = null
                }
            }
            var openRequests = this.loadingBay.childNodes;
            for (var j = openRequests.length - 1; j >= 0; j--) {
                var img = openRequests[j];
                if (!(img.id in validIds)) {
                    this.loadingBay.removeChild(img);
                    this.openRequestCount--;
                    img.src = img.coord = img.onload = img.onerror = null
                }
            }
            for (var id in this.requestsById) {
                if (!(id in validIds)) {
                    if (this.requestsById.hasOwnProperty(id)) {
                        var requestToRemove = this.requestsById[id];
                        delete this.requestsById[id];
                        if (requestToRemove !== null) {
                            requestToRemove = requestToRemove.id = requestToRemove.coord = requestToRemove.url = null
                        }
                    }
                }
            }
        },
        hasRequest: function(id) {
            return id in this.requestsById
        },
        requestTile: function(id, coord, url) {
            if (!(id in this.requestsById)) {
                var request = {
                    id: id,
                    coord: coord.copy(),
                    url: url
                };
                this.requestsById[id] = request;
                if (url) {
                    this.requestQueue.push(request)
                }
            }
        },
        getProcessQueue: function() {
            if (!this._processQueue) {
                var theManager = this;
                this._processQueue = function() {
                    theManager.processQueue()
                }
            }
            return this._processQueue
        },
        processQueue: function(sortFunc) {
            if (sortFunc && this.requestQueue.length > 8) {
                this.requestQueue.sort(sortFunc)
            }
            while (this.openRequestCount < this.maxOpenRequests && this.requestQueue.length > 0) {
                var request = this.requestQueue.pop();
                if (request) {
                    this.openRequestCount++;
                    var img = document.createElement("img");
                    img.id = request.id;
                    img.style.position = "absolute";
                    img.coord = request.coord;
                    this.loadingBay.appendChild(img);
                    img.onload = img.onerror = this.getLoadComplete();
                    img.src = request.url;
                    request = request.id = request.coord = request.url = null
                }
            }
        },
        _loadComplete: null,
        getLoadComplete: function() {
            if (!this._loadComplete) {
                var theManager = this;
                this._loadComplete = function(e) {
                    e = e || window.event;
                    var img = e.srcElement || e.target;
                    img.onload = img.onerror = null;
                    theManager.loadingBay.removeChild(img);
                    theManager.openRequestCount--;
                    delete theManager.requestsById[img.id];
                    if (e.type === "load" && (img.complete || img.readyState && img.readyState == "complete")) {
                        theManager.dispatchCallback("requestcomplete", img)
                    } else {
                        theManager.dispatchCallback("requesterror", {
                            element: img,
                            url: "" + img.src
                        });
                        img.src = null
                    }
                    setTimeout(theManager.getProcessQueue(), 0)
                }
            }
            return this._loadComplete
        }
    };
    MM.Layer = function(provider, parent, name) {
        this.parent = parent || document.createElement("div");
        this.parent.style.cssText = "position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; margin: 0; padding: 0; z-index: 0";
        this.name = name;
        this.levels = {};
        this.requestManager = new MM.RequestManager;
        this.requestManager.addCallback("requestcomplete", this.getTileComplete());
        this.requestManager.addCallback("requesterror", this.getTileError());
        if (provider) this.setProvider(provider)
    };
    MM.Layer.prototype = {
        map: null,
        parent: null,
        name: null,
        enabled: true,
        tiles: null,
        levels: null,
        requestManager: null,
        provider: null,
        _tileComplete: null,
        getTileComplete: function() {
            if (!this._tileComplete) {
                var theLayer = this;
                this._tileComplete = function(manager, tile) {
                    theLayer.tiles[tile.id] = tile;
                    theLayer.positionTile(tile);
                    tile.style.visibility = "inherit";
                    tile.className = "map-tile-loaded"
                }
            }
            return this._tileComplete
        },
        getTileError: function() {
            if (!this._tileError) {
                var theLayer = this;
                this._tileError = function(manager, tile) {
                    tile.onload = tile.onerror = null;
                    theLayer.tiles[tile.element.id] = tile.element;
                    theLayer.positionTile(tile.element);
                    tile.element.style.visibility = "hidden"
                }
            }
            return this._tileError
        },
        draw: function() {
            if (!this.enabled || !this.map) return;
            var theCoord = this.map.coordinate.zoomTo(Math.round(this.map.coordinate.zoom));

            function centerDistanceCompare(r1, r2) {
                if (r1 && r2) {
                    var c1 = r1.coord;
                    var c2 = r2.coord;
                    if (c1.zoom == c2.zoom) {
                        var ds1 = Math.abs(theCoord.row - c1.row - .5) + Math.abs(theCoord.column - c1.column - .5);
                        var ds2 = Math.abs(theCoord.row - c2.row - .5) + Math.abs(theCoord.column - c2.column - .5);
                        return ds1 < ds2 ? 1 : ds1 > ds2 ? -1 : 0
                    } else {
                        return c1.zoom < c2.zoom ? 1 : c1.zoom > c2.zoom ? -1 : 0
                    }
                }
                return r1 ? 1 : r2 ? -1 : 0
            }
            var baseZoom = Math.round(this.map.coordinate.zoom);
            var startCoord = this.map.pointCoordinate(new MM.Point(0, 0)).zoomTo(baseZoom).container();
            var endCoord = this.map.pointCoordinate(this.map.dimensions).zoomTo(baseZoom).container().right().down();
            var validTileKeys = {};
            var levelElement = this.createOrGetLevel(startCoord.zoom);
            var tileCoord = startCoord.copy();
            for (tileCoord.column = startCoord.column; tileCoord.column < endCoord.column; tileCoord.column++) {
                for (tileCoord.row = startCoord.row; tileCoord.row < endCoord.row; tileCoord.row++) {
                    var validKeys = this.inventoryVisibleTile(levelElement, tileCoord);
                    while (validKeys.length) {
                        validTileKeys[validKeys.pop()] = true
                    }
                }
            }
            for (var name in this.levels) {
                if (this.levels.hasOwnProperty(name)) {
                    var zoom = parseInt(name, 10);
                    if (zoom >= startCoord.zoom - 5 && zoom < startCoord.zoom + 2) {
                        continue
                    }
                    var level = this.levels[name];
                    level.style.display = "none";
                    var visibleTiles = this.tileElementsInLevel(level);
                    while (visibleTiles.length) {
                        this.provider.releaseTile(visibleTiles[0].coord);
                        this.requestManager.clearRequest(visibleTiles[0].coord.toKey());
                        level.removeChild(visibleTiles[0]);
                        visibleTiles.shift()
                    }
                }
            }
            var minLevel = startCoord.zoom - 5;
            var maxLevel = startCoord.zoom + 2;
            for (var z = minLevel; z < maxLevel; z++) {
                this.adjustVisibleLevel(this.levels[z], z, validTileKeys)
            }
            this.requestManager.clearExcept(validTileKeys);
            this.requestManager.processQueue(centerDistanceCompare)
        },
        inventoryVisibleTile: function(layer_element, tile_coord) {
            var tile_key = tile_coord.toKey(),
                valid_tile_keys = [tile_key];
            if (tile_key in this.tiles) {
                var tile = this.tiles[tile_key];
                if (tile.parentNode != layer_element) {
                    layer_element.appendChild(tile);
                    if ("reAddTile" in this.provider) {
                        this.provider.reAddTile(tile_key, tile_coord, tile)
                    }
                }
                return valid_tile_keys
            }
            if (!this.requestManager.hasRequest(tile_key)) {
                var tileToRequest = this.provider.getTile(tile_coord);
                if (typeof tileToRequest == "string") {
                    this.addTileImage(tile_key, tile_coord, tileToRequest)
                } else if (tileToRequest) {
                    this.addTileElement(tile_key, tile_coord, tileToRequest)
                }
            }
            var tileCovered = false;
            var maxStepsOut = tile_coord.zoom;
            for (var pz = 1; pz <= maxStepsOut; pz++) {
                var parent_coord = tile_coord.zoomBy(-pz).container();
                var parent_key = parent_coord.toKey();
                if (parent_key in this.tiles) {
                    valid_tile_keys.push(parent_key);
                    tileCovered = true;
                    break
                }
            }
            if (!tileCovered) {
                var child_coord = tile_coord.zoomBy(1);
                valid_tile_keys.push(child_coord.toKey());
                child_coord.column += 1;
                valid_tile_keys.push(child_coord.toKey());
                child_coord.row += 1;
                valid_tile_keys.push(child_coord.toKey());
                child_coord.column -= 1;
                valid_tile_keys.push(child_coord.toKey())
            }
            return valid_tile_keys
        },
        tileElementsInLevel: function(level) {
            var tiles = [];
            for (var tile = level.firstChild; tile; tile = tile.nextSibling) {
                if (tile.nodeType == 1) {
                    tiles.push(tile)
                }
            }
            return tiles
        },
        adjustVisibleLevel: function(level, zoom, valid_tile_keys) {
            if (!level) return;
            var scale = 1;
            var theCoord = this.map.coordinate.copy();
            if (level.childNodes.length > 0) {
                level.style.display = "block";
                scale = Math.pow(2, this.map.coordinate.zoom - zoom);
                theCoord = theCoord.zoomTo(zoom)
            } else {
                level.style.display = "none";
                return false
            }
            var tileWidth = this.map.tileSize.x * scale;
            var tileHeight = this.map.tileSize.y * scale;
            var center = new MM.Point(this.map.dimensions.x * .5, this.map.dimensions.y * .5);
            var tiles = this.tileElementsInLevel(level);
            while (tiles.length) {
                var tile = tiles.pop();
                if (!valid_tile_keys[tile.id]) {
                    this.provider.releaseTile(tile.coord);
                    this.requestManager.clearRequest(tile.coord.toKey());
                    level.removeChild(tile)
                } else {
                    MM.moveElement(tile, {
                        x: Math.round(center.x + (tile.coord.column - theCoord.column) * tileWidth),
                        y: Math.round(center.y + (tile.coord.row - theCoord.row) * tileHeight),
                        scale: scale,
                        width: this.map.tileSize.x,
                        height: this.map.tileSize.y
                    })
                }
            }
        },
        createOrGetLevel: function(zoom) {
            if (zoom in this.levels) {
                return this.levels[zoom]
            }
            var level = document.createElement("div");
            level.id = this.parent.id + "-zoom-" + zoom;
            level.style.cssText = "position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; margin: 0; padding: 0;";
            level.style.zIndex = zoom;
            this.parent.appendChild(level);
            this.levels[zoom] = level;
            return level
        },
        addTileImage: function(key, coord, url) {
            this.requestManager.requestTile(key, coord, url)
        },
        addTileElement: function(key, coordinate, element) {
            element.id = key;
            element.coord = coordinate.copy();
            this.positionTile(element)
        },
        positionTile: function(tile) {
            var theCoord = this.map.coordinate.zoomTo(tile.coord.zoom);
            tile.style.cssText = "position:absolute;-webkit-user-select:none;" + "-webkit-user-drag:none;-moz-user-drag:none;-webkit-transform-origin:0 0;" + "-moz-transform-origin:0 0;-o-transform-origin:0 0;-ms-transform-origin:0 0;" + "width:" + this.map.tileSize.x + "px; height: " + this.map.tileSize.y + "px;";
            tile.ondragstart = function() {
                return false
            };
            var scale = Math.pow(2, this.map.coordinate.zoom - tile.coord.zoom);
            MM.moveElement(tile, {
                x: Math.round(this.map.dimensions.x * .5 + (tile.coord.column - theCoord.column) * this.map.tileSize.x * scale),
                y: Math.round(this.map.dimensions.y * .5 + (tile.coord.row - theCoord.row) * this.map.tileSize.y * scale),
                scale: scale,
                width: this.map.tileSize.x,
                height: this.map.tileSize.y
            });
            var theLevel = this.levels[tile.coord.zoom];
            theLevel.appendChild(tile);
            if (Math.round(this.map.coordinate.zoom) == tile.coord.zoom) {
                theLevel.style.display = "block"
            }
            this.requestRedraw()
        },
        _redrawTimer: undefined,
        requestRedraw: function() {
            if (!this._redrawTimer) {
                this._redrawTimer = setTimeout(this.getRedraw(), 1e3)
            }
        },
        _redraw: null,
        getRedraw: function() {
            if (!this._redraw) {
                var theLayer = this;
                this._redraw = function() {
                    theLayer.draw();
                    theLayer._redrawTimer = 0
                }
            }
            return this._redraw
        },
        setProvider: function(newProvider) {
            var firstProvider = this.provider === null;
            if (!firstProvider) {
                this.requestManager.clear();
                for (var name in this.levels) {
                    if (this.levels.hasOwnProperty(name)) {
                        var level = this.levels[name];
                        while (level.firstChild) {
                            this.provider.releaseTile(level.firstChild.coord);
                            level.removeChild(level.firstChild)
                        }
                    }
                }
            }
            this.tiles = {};
            this.provider = newProvider;
            if (!firstProvider) {
                this.draw()
            }
        },
        enable: function() {
            this.enabled = true;
            this.parent.style.display = "";
            this.draw();
            return this
        },
        disable: function() {
            this.enabled = false;
            this.requestManager.clear();
            this.parent.style.display = "none";
            return this
        },
        destroy: function() {
            this.requestManager.clear();
            this.requestManager.removeCallback("requestcomplete", this.getTileComplete());
            this.requestManager.removeCallback("requesterror", this.getTileError());
            this.provider = null;
            if (this.parent.parentNode) {
                this.parent.parentNode.removeChild(this.parent)
            }
            this.map = null
        }
    };
    MM.Map = function(parent, layerOrLayers, dimensions, eventHandlers) {
        if (typeof parent == "string") {
            parent = document.getElementById(parent);
            if (!parent) {
                throw "The ID provided to modest maps could not be found."
            }
        }
        this.parent = parent;
        this.parent.style.padding = "0";
        this.parent.style.overflow = "hidden";
        var position = MM.getStyle(this.parent, "position");
        if (position != "relative" && position != "absolute") {
            this.parent.style.position = "relative"
        }
        this.layers = [];
        if (!layerOrLayers) {
            layerOrLayers = []
        }
        if (!(layerOrLayers instanceof Array)) {
            layerOrLayers = [layerOrLayers]
        }
        for (var i = 0; i < layerOrLayers.length; i++) {
            this.addLayer(layerOrLayers[i])
        }
        this.projection = new MM.MercatorProjection(0, MM.deriveTransformation(-Math.PI, Math.PI, 0, 0, Math.PI, Math.PI, 1, 0, -Math.PI, -Math.PI, 0, 1));
        this.tileSize = new MM.Point(256, 256);
        this.coordLimits = [new MM.Coordinate(0, -Infinity, 0), new MM.Coordinate(1, Infinity, 0).zoomTo(18)];
        this.coordinate = new MM.Coordinate(.5, .5, 0);
        if (!dimensions) {
            dimensions = new MM.Point(this.parent.offsetWidth, this.parent.offsetHeight);
            this.autoSize = true;
            MM.addEvent(window, "resize", this.windowResize())
        } else {
            this.autoSize = false;
            this.parent.style.width = Math.round(dimensions.x) + "px";
            this.parent.style.height = Math.round(dimensions.y) + "px"
        }
        this.dimensions = dimensions;
        this.callbackManager = new MM.CallbackManager(this, ["zoomed", "panned", "centered", "extentset", "resized", "drawn"]);
        if (eventHandlers === undefined) {
            this.eventHandlers = [MM.MouseHandler().init(this), MM.TouchHandler().init(this)]
        } else {
            this.eventHandlers = eventHandlers;
            if (eventHandlers instanceof Array) {
                for (var j = 0; j < eventHandlers.length; j++) {
                    eventHandlers[j].init(this)
                }
            }
        }
    };
    MM.Map.prototype = {
        parent: null,
        dimensions: null,
        projection: null,
        coordinate: null,
        tileSize: null,
        coordLimits: null,
        layers: null,
        callbackManager: null,
        eventHandlers: null,
        autoSize: null,
        toString: function() {
            return "Map(#" + this.parent.id + ")"
        },
        addCallback: function(event, callback) {
            this.callbackManager.addCallback(event, callback);
            return this
        },
        removeCallback: function(event, callback) {
            this.callbackManager.removeCallback(event, callback);
            return this
        },
        dispatchCallback: function(event, message) {
            this.callbackManager.dispatchCallback(event, message);
            return this
        },
        getHandler: function(id, mHandler) {
            var handler = null,
                rel = this.eventHandlers;
            if (mHandler === true) {
                rel = this.getHandler("MouseHandler", false);
                if (!rel) return handler;
                rel = rel.handlers
            }
            if (!rel) return handler;
            for (var l = 0; l < rel.length; l++) {
                if (typeof rel[l].id === "string" && rel[l].id === id) {
                    handler = rel[l];
                    break
                }
            }
            if (!handler && typeof mHandler !== "boolean") {
                return this.getHandler(id, true)
            }
            return handler
        },
        disableHandler: function(id) {
            var handler = this.getHandler(id);
            if (handler && typeof handler.remove === "function") handler.remove();
            return this
        },
        enableHandler: function(id) {
            var handler = this.getHandler(id);
            if (handler && typeof handler.remove === "function") handler.init(this);
            return this
        },
        removeHandler: function(id) {
            var handler = this.getHandler(id),
                index = this.eventHandlers.indexOf(handler);
            if (index === -1) {
                var mouseHandler = this.getHandler("MouseHandler");
                index = mouseHandler.handlers.indexOf(handler);
                if (index !== -1) {
                    handler.remove();
                    mouseHandler.handlers.splice(index, 1)
                }
                return
            }
            handler.remove();
            this.eventHandlers.splice(index, 1);
            return handler
        },
        addHandler: function(handler) {
            handler.init(this);
            if (typeof handler.id !== "string") {
                throw new Error("Handler lacks the required id attribute")
            }
            this.eventHandlers.push(handler);
            return this
        },
        windowResize: function() {
            if (!this._windowResize) {
                var theMap = this;
                this._windowResize = function(event) {
                    theMap.dimensions = new MM.Point(theMap.parent.offsetWidth, theMap.parent.offsetHeight);
                    theMap.draw();
                    theMap.dispatchCallback("resized", [theMap.dimensions])
                }
            }
            return this._windowResize
        },
        setZoomRange: function(minZoom, maxZoom) {
            this.coordLimits[0] = this.coordLimits[0].zoomTo(minZoom);
            this.coordLimits[1] = this.coordLimits[1].zoomTo(maxZoom);
            return this
        },
        zoomBy: function(zoomOffset) {
            this.coordinate = this.enforceLimits(this.coordinate.zoomBy(zoomOffset));
            MM.getFrame(this.getRedraw());
            this.dispatchCallback("zoomed", zoomOffset);
            return this
        },
        zoomIn: function() {
            return this.zoomBy(1)
        },
        zoomOut: function() {
            return this.zoomBy(-1)
        },
        setZoom: function(z) {
            return this.zoomBy(z - this.coordinate.zoom)
        },
        zoomByAbout: function(zoomOffset, point) {
            var location = this.pointLocation(point);
            this.coordinate = this.enforceLimits(this.coordinate.zoomBy(zoomOffset));
            var newPoint = this.locationPoint(location);
            this.dispatchCallback("zoomed", zoomOffset);
            return this.panBy(point.x - newPoint.x, point.y - newPoint.y)
        },
        panBy: function(dx, dy) {
            this.coordinate.column -= dx / this.tileSize.x;
            this.coordinate.row -= dy / this.tileSize.y;
            this.coordinate = this.enforceLimits(this.coordinate);
            MM.getFrame(this.getRedraw());
            this.dispatchCallback("panned", [dx, dy]);
            return this
        },
        panLeft: function() {
            return this.panBy(100, 0)
        },
        panRight: function() {
            return this.panBy(-100, 0)
        },
        panDown: function() {
            return this.panBy(0, -100)
        },
        panUp: function() {
            return this.panBy(0, 100)
        },
        setCenter: function(location) {
            return this.setCenterZoom(location, this.coordinate.zoom)
        },
        setCenterZoom: function(location, zoom) {
            this.coordinate = this.projection.locationCoordinate(location).zoomTo(parseFloat(zoom) || 0);
            this.coordinate = this.enforceLimits(this.coordinate);
            MM.getFrame(this.getRedraw());
            this.dispatchCallback("centered", [location, zoom]);
            return this
        },
        extentCoordinate: function(locations, precise) {
            if (locations instanceof MM.Extent) {
                locations = locations.toArray()
            }
            var TL, BR;
            for (var i = 0; i < locations.length; i++) {
                var coordinate = this.projection.locationCoordinate(locations[i]);
                if (TL) {
                    TL.row = Math.min(TL.row, coordinate.row);
                    TL.column = Math.min(TL.column, coordinate.column);
                    TL.zoom = Math.min(TL.zoom, coordinate.zoom);
                    BR.row = Math.max(BR.row, coordinate.row);
                    BR.column = Math.max(BR.column, coordinate.column);
                    BR.zoom = Math.max(BR.zoom, coordinate.zoom)
                } else {
                    TL = coordinate.copy();
                    BR = coordinate.copy()
                }
            }
            var width = this.dimensions.x + 1;
            var height = this.dimensions.y + 1;
            var hFactor = (BR.column - TL.column) / (width / this.tileSize.x);
            var hZoomDiff = Math.log(hFactor) / Math.log(2);
            var hPossibleZoom = TL.zoom - (precise ? hZoomDiff : Math.ceil(hZoomDiff));
            var vFactor = (BR.row - TL.row) / (height / this.tileSize.y);
            var vZoomDiff = Math.log(vFactor) / Math.log(2);
            var vPossibleZoom = TL.zoom - (precise ? vZoomDiff : Math.ceil(vZoomDiff));
            var initZoom = Math.min(hPossibleZoom, vPossibleZoom);
            initZoom = Math.min(initZoom, this.coordLimits[1].zoom);
            initZoom = Math.max(initZoom, this.coordLimits[0].zoom);
            var centerRow = (TL.row + BR.row) / 2;
            var centerColumn = (TL.column + BR.column) / 2;
            var centerZoom = TL.zoom;
            return new MM.Coordinate(centerRow, centerColumn, centerZoom).zoomTo(initZoom)
        },
        setExtent: function(locations, precise) {
            this.coordinate = this.extentCoordinate(locations, precise);
            this.coordinate = this.enforceLimits(this.coordinate);
            MM.getFrame(this.getRedraw());
            this.dispatchCallback("extentset", locations);
            return this
        },
        setSize: function(dimensions) {
            this.dimensions = new MM.Point(dimensions.x, dimensions.y);
            this.parent.style.width = Math.round(this.dimensions.x) + "px";
            this.parent.style.height = Math.round(this.dimensions.y) + "px";
            if (this.autoSize) {
                MM.removeEvent(window, "resize", this.windowResize());
                this.autoSize = false
            }
            this.draw();
            this.dispatchCallback("resized", this.dimensions);
            return this
        },
        coordinatePoint: function(coord) {
            if (coord.zoom != this.coordinate.zoom) {
                coord = coord.zoomTo(this.coordinate.zoom)
            }
            var point = new MM.Point(this.dimensions.x / 2, this.dimensions.y / 2);
            point.x += this.tileSize.x * (coord.column - this.coordinate.column);
            point.y += this.tileSize.y * (coord.row - this.coordinate.row);
            return point
        },
        pointCoordinate: function(point) {
            var coord = this.coordinate.copy();
            coord.column += (point.x - this.dimensions.x / 2) / this.tileSize.x;
            coord.row += (point.y - this.dimensions.y / 2) / this.tileSize.y;
            return coord
        },
        locationCoordinate: function(location) {
            return this.projection.locationCoordinate(location)
        },
        coordinateLocation: function(coordinate) {
            return this.projection.coordinateLocation(coordinate)
        },
        locationPoint: function(location) {
            return this.coordinatePoint(this.locationCoordinate(location))
        },
        pointLocation: function(point) {
            return this.coordinateLocation(this.pointCoordinate(point))
        },
        getExtent: function() {
            return new MM.Extent(this.pointLocation(new MM.Point(0, 0)), this.pointLocation(this.dimensions))
        },
        extent: function(locations, precise) {
            if (locations) {
                return this.setExtent(locations, precise)
            } else {
                return this.getExtent()
            }
        },
        getCenter: function() {
            return this.projection.coordinateLocation(this.coordinate)
        },
        center: function(location) {
            if (location) {
                return this.setCenter(location)
            } else {
                return this.getCenter()
            }
        },
        getZoom: function() {
            return this.coordinate.zoom
        },
        zoom: function(zoom) {
            if (zoom !== undefined) {
                return this.setZoom(zoom)
            } else {
                return this.getZoom()
            }
        },
        getLayers: function() {
            return this.layers.slice()
        },
        getLayer: function(name) {
            for (var i = 0; i < this.layers.length; i++) {
                if (name == this.layers[i].name) return this.layers[i]
            }
        },
        getLayerAt: function(index) {
            return this.layers[index]
        },
        addLayer: function(layer) {
            this.layers.push(layer);
            this.parent.appendChild(layer.parent);
            layer.map = this;
            if (this.coordinate) {
                MM.getFrame(this.getRedraw())
            }
            return this
        },
        removeLayer: function(layer) {
            for (var i = 0; i < this.layers.length; i++) {
                if (layer == this.layers[i] || layer == this.layers[i].name) {
                    this.removeLayerAt(i);
                    break
                }
            }
            return this
        },
        setLayerAt: function(index, layer) {
            if (index < 0 || index >= this.layers.length) {
                throw new Error("invalid index in setLayerAt(): " + index)
            }
            if (this.layers[index] != layer) {
                if (index < this.layers.length) {
                    var other = this.layers[index];
                    this.parent.insertBefore(layer.parent, other.parent);
                    other.destroy()
                } else {
                    this.parent.appendChild(layer.parent)
                }
                this.layers[index] = layer;
                layer.map = this;
                MM.getFrame(this.getRedraw())
            }
            return this
        },
        insertLayerAt: function(index, layer) {
            if (index < 0 || index > this.layers.length) {
                throw new Error("invalid index in insertLayerAt(): " + index)
            }
            if (index == this.layers.length) {
                this.layers.push(layer);
                this.parent.appendChild(layer.parent)
            } else {
                var other = this.layers[index];
                this.parent.insertBefore(layer.parent, other.parent);
                this.layers.splice(index, 0, layer)
            }
            layer.map = this;
            MM.getFrame(this.getRedraw());
            return this
        },
        removeLayerAt: function(index) {
            if (index < 0 || index >= this.layers.length) {
                throw new Error("invalid index in removeLayer(): " + index)
            }
            var old = this.layers[index];
            this.layers.splice(index, 1);
            old.destroy();
            return this
        },
        swapLayersAt: function(i, j) {
            if (i < 0 || i >= this.layers.length || j < 0 || j >= this.layers.length) {
                throw new Error("invalid index in swapLayersAt(): " + index)
            }
            var layer1 = this.layers[i],
                layer2 = this.layers[j],
                dummy = document.createElement("div");
            this.parent.replaceChild(dummy, layer2.parent);
            this.parent.replaceChild(layer2.parent, layer1.parent);
            this.parent.replaceChild(layer1.parent, dummy);
            this.layers[i] = layer2;
            this.layers[j] = layer1;
            return this
        },
        enableLayer: function(name) {
            var l = this.getLayer(name);
            if (l) l.enable();
            return this
        },
        enableLayerAt: function(index) {
            var l = this.getLayerAt(index);
            if (l) l.enable();
            return this
        },
        disableLayer: function(name) {
            var l = this.getLayer(name);
            if (l) l.disable();
            return this
        },
        disableLayerAt: function(index) {
            var l = this.getLayerAt(index);
            if (l) l.disable();
            return this
        },
        enforceZoomLimits: function(coord) {
            var limits = this.coordLimits;
            if (limits) {
                var minZoom = limits[0].zoom;
                var maxZoom = limits[1].zoom;
                if (coord.zoom < minZoom) {
                    coord = coord.zoomTo(minZoom)
                } else if (coord.zoom > maxZoom) {
                    coord = coord.zoomTo(maxZoom)
                }
            }
            return coord
        },
        enforcePanLimits: function(coord) {
            if (this.coordLimits) {
                coord = coord.copy();
                var topLeftLimit = this.coordLimits[0].zoomTo(coord.zoom);
                var bottomRightLimit = this.coordLimits[1].zoomTo(coord.zoom);
                var currentTopLeft = this.pointCoordinate(new MM.Point(0, 0)).zoomTo(coord.zoom);
                var currentBottomRight = this.pointCoordinate(this.dimensions).zoomTo(coord.zoom);
                if (bottomRightLimit.row - topLeftLimit.row < currentBottomRight.row - currentTopLeft.row) {
                    coord.row = (bottomRightLimit.row + topLeftLimit.row) / 2
                } else {
                    if (currentTopLeft.row < topLeftLimit.row) {
                        coord.row += topLeftLimit.row - currentTopLeft.row
                    } else if (currentBottomRight.row > bottomRightLimit.row) {
                        coord.row -= currentBottomRight.row - bottomRightLimit.row
                    }
                } if (bottomRightLimit.column - topLeftLimit.column < currentBottomRight.column - currentTopLeft.column) {
                    coord.column = (bottomRightLimit.column + topLeftLimit.column) / 2
                } else {
                    if (currentTopLeft.column < topLeftLimit.column) {
                        coord.column += topLeftLimit.column - currentTopLeft.column
                    } else if (currentBottomRight.column > bottomRightLimit.column) {
                        coord.column -= currentBottomRight.column - bottomRightLimit.column
                    }
                }
            }
            return coord
        },
        enforceLimits: function(coord) {
            return this.enforcePanLimits(this.enforceZoomLimits(coord))
        },
        draw: function() {
            this.coordinate = this.enforceLimits(this.coordinate);
            if (this.dimensions.x <= 0 || this.dimensions.y <= 0) {
                if (this.autoSize) {
                    var w = this.parent.offsetWidth,
                        h = this.parent.offsetHeight;
                    this.dimensions = new MM.Point(w, h);
                    if (w <= 0 || h <= 0) {
                        return
                    }
                } else {
                    return
                }
            }
            for (var i = 0; i < this.layers.length; i++) {
                this.layers[i].draw()
            }
            this.dispatchCallback("drawn")
        },
        _redrawTimer: undefined,
        requestRedraw: function() {
            if (!this._redrawTimer) {
                this._redrawTimer = setTimeout(this.getRedraw(), 1e3)
            }
        },
        _redraw: null,
        getRedraw: function() {
            if (!this._redraw) {
                var theMap = this;
                this._redraw = function() {
                    theMap.draw();
                    theMap._redrawTimer = 0
                }
            }
            return this._redraw
        },
        destroy: function() {
            for (var j = 0; j < this.layers.length; j++) {
                this.layers[j].destroy()
            }
            this.layers = [];
            this.projection = null;
            for (var i = 0; i < this.eventHandlers.length; i++) {
                this.eventHandlers[i].remove()
            }
            if (this.autoSize) {
                MM.removeEvent(window, "resize", this.windowResize())
            }
        }
    };
    MM.mapByCenterZoom = function(parent, layerish, location, zoom) {
        var layer = MM.coerceLayer(layerish),
            map = new MM.Map(parent, layer, false);
        map.setCenterZoom(location, zoom).draw();
        return map
    };
    MM.mapByExtent = function(parent, layerish, locationA, locationB) {
        var layer = MM.coerceLayer(layerish),
            map = new MM.Map(parent, layer, false);
        map.setExtent([locationA, locationB]).draw();
        return map
    };
    if (typeof module !== "undefined" && module.exports) {
        module.exports = {
            Point: MM.Point,
            Projection: MM.Projection,
            MercatorProjection: MM.MercatorProjection,
            LinearProjection: MM.LinearProjection,
            Transformation: MM.Transformation,
            Location: MM.Location,
            MapProvider: MM.MapProvider,
            Template: MM.Template,
            Coordinate: MM.Coordinate,
            deriveTransformation: MM.deriveTransformation
        }
    }
})(MM);