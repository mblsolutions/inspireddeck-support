let {Form} = require('../support/Form');

export class FindCode extends Form {

    /**
     * Find Code
     */
    constructor(data, selected = null) {
        super(data);

        this.selected = selected;
    }

    /**
     * Search for a Code
     *
     * @return {Promise}
     */
    search() {
        let self = this;

        return new Promise(resolve => {
            self.request('/async/code/search', 'post')
                .then(response => {
                    self.selected = response.data.data;
                    resolve(self.selected);
                });
        });

    }

}