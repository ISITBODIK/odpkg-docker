class Ckan::GeodataFindService < ServiceBase

  def initialize(org, tag)
    @org = org
    @tag = tag
  end

  def perform

    query = 'organization:(' + @org + ') AND tags:(' + @tag + ')'

    package_search = Ckan::PackageSearchService.new(query)
    datasets = package_search.call

    groups = []
    list = []

    datasets.each do |dataset|
      group = ''
      if 0 != dataset[:groups].size
        group = dataset[:groups][0][:title]
        groups << group
      end
      dataset[:resources].each do |resource|
        if ['XLSX', 'XLS', 'CSV'].include?(resource[:format])
          list << { id: resource[:id], name: resource[:name], group: group }
        end
      end
    end

    [groups.uniq, list]
  end

end