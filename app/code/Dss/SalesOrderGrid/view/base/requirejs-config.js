var config = {
    map: {
        '*': {
            'ui/template/grid/paging-total':
                'Dss_SalesOrderGrid/template/grid/paging-total'
        }
    },
    'config': {
        'mixins': {
            'Magento_Ui/js/grid/provider': {
                'Dss_SalesOrderGrid/js/grid/provider': true
            }
        }
    }
};
