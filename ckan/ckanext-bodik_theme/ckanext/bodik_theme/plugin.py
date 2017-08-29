import ckan.plugins as plugins
import ckan.plugins.toolkit as toolkit
import ckan.lib.helpers as helpers
import logging
import datetime

log = logging.getLogger('bodik_theme')

class BodikThemePlugin(plugins.SingletonPlugin):
    plugins.implements(plugins.IConfigurable)
    plugins.implements(plugins.IConfigurer)
    plugins.implements(plugins.ITemplateHelpers)

    # IConfigurable
    def configure(self, config):
        self.main_web = config.get('odpkg.main_web')
        self.dashboard = config.get('odpkg.dashboard')
        self.thumbnail_count = config.get('odpkg.thumbnail_count')

    # IConfigurer
    def update_config(self, config):
        toolkit.add_template_directory(config, 'templates')
        toolkit.add_public_directory(config, 'public')
        toolkit.add_resource('fanstatic', 'bodik_theme')

    # ITemplateHelpers
    def get_helpers(self):
        return {
            'odpkg_main_web': self._main_web,
            'odpkg_dashboard': self._dashboard,
            'odpkg_thumbnail_count': self._thumbnail_count,
            'odpkg_first_resource_view': self._first_resource_view,
            'odpkg_resource_view_list': self._resource_view_list,
            'bodik_theme_render_datetime': self._render_datetime,
        }

    def _main_web(self):
        return self.main_web

    def _dashboard(self):
        return self.dashboard

    def _thumbnail_count(self):
        return int(self.thumbnail_count)

    def _resource_view_list(self, package):
        if 0 < package['num_resources']:
            if package.has_key('resources'):
                resource = package['resources'][0]
                view_list = toolkit.get_action('resource_view_list')( data_dict={ 'id':resource['id'] } )
                return view_list
            else:
                return False
        else:
            return False

    def _first_resource_view(self, package):
        if 0 < package['num_resources']:
            resource = package['resources'][0]
            view_list = toolkit.get_action('resource_view_list')( data_dict={ 'id':resource['id'] } )
            if 0 < len(view_list):
                return view_list[0]
            else:
                return False
        else:
            return False

    def _render_datetime(self, datetime_, date_format=None, with_hours=False):
        datetime_ = helpers._datestamp_to_datetime(datetime_)
        if datetime_ == None:
            return False
        else:
            jstTime = datetime_ + datetime.timedelta(hours=9)
            return helpers.render_datetime(jstTime, date_format, with_hours)
