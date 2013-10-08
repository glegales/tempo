/*
---
name: Element.Data
description: Stores data in HTML5 data properties
provides: [Element.Data]
requires: [Core/Element, Core/JSON]
script: Element.Data.js

...
*/
(function(){

    function formatDataProperty(prop) {
        return prop.replace('data-', '').camelCase()
    }

    [Document, Element].invoke('implement', {

        data: function(property, force) {
            var data = this.retrieve('dataCollection'),
                ii = 0,
                len,
                hasData = false,
                attribs

            if (!data || force === true) {
                data = {}
                attribs = this.attributes || []
                for (len = attribs.length; ii < len; ++ii) {
                    if (attribs[ii].name.indexOf('data-') === 0) {
                        data[formatDataProperty(attribs[ii].name)] = attribs[ii].value
                        hasData = true
                    }
                }

                if (!hasData)
                    data = null

                this.store('dataCollection', data)
            }

            return property ? data[formatDataProperty(property)] || null : data
        }
    })

	JSON.isSecure = function(string){
		//this verifies that the string is parsable JSON and not malicious (borrowed from JSON.js in MooTools, which in turn borrowed it from Crockford)
		//this version is a little more permissive, as it allows single quoted attributes because forcing the use of double quotes
		//is a pain when this stuff is used as HTML properties
		return (/^[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]*$/).test(string.replace(/\\./g, '@').replace(/"[^"\\\n\r]*"/g, '').replace(/'[^'\\\n\r]*'/g, ''));
	};

	Element.implement({
		/*
			sets an HTML5 data property.
			arguments:
				name - (string) the data name to store; will be automatically prefixed with 'data-'.
				value - (string, number) the value to store.
		*/
		setData: function(name, value){
			return this.set('data-' + name.hyphenate(), value);
		},

		getData: function(name, defaultValue){
			var value = this.get('data-' + name.hyphenate());
			if (value != undefined){
				return value;
			} else if (defaultValue != undefined){
				this.setData(name, defaultValue);
				return defaultValue;
			}
		},

		/* 
			arguments:
				name - (string) the data name to store; will be automatically prefixed with 'data-'
				value - (string, array, or object) if an object or array the object will be JSON encoded; otherwise stored as provided.
		*/
		setJSONData: function(name, value){
			return this.setData(name, JSON.encode(value));
		},

		/*
			retrieves a property from HTML5 data property you specify
		
			arguments:
				name - (retrieve) the data name to store; will be automatically prefixed with 'data-'
				strict - (boolean) if true, will set the JSON.decode's secure flag to true; otherwise the value is still tested but allows single quoted attributes.
				defaultValue - (string, array, or object) the value to set if no value is found (see storeData above)
		*/
		getJSONData: function(name, strict, defaultValue){
			var value = this.get('data-' + name);
			if (value != undefined){
				if (value && JSON.isSecure(value)) {
					return JSON.decode(value, strict);
				} else {
					return value;
				}
			} else if (defaultValue != undefined){
				this.setJSONData(name, defaultValue);
				return defaultValue;
			}
		},
        setFocus: function(index) {
            this.setAttribute('tabIndex',index || 0);
            this.focus();
            console.log(this);
        }


	});

})();