class Geo::PointDataBuilderService < ServiceBase

  def initialize(geojson, rows)
    @geojson = geojson
    @rows = rows
  end

  def perform
    header = @rows.shift

    lat_idx = header.index('緯度')
    raise '緯度エラー' if lat_idx.nil?

    lng_idx = header.index('経度')
    raise '経度エラー' if lng_idx.nil?

    @rows.each do |row|
      feature = {
        geometry: {
          coordinates: [],
          type: 'Point'
        },
        properties: {
        },
        type: 'Feature'
      }

      feature[:geometry][:coordinates] = [row[lng_idx].to_f, row[lat_idx].to_f]

      header.each_with_index do |field, idx|
        feature[:properties][field] = row[idx].to_s
      end

      @geojson[:features] << feature
    end

    @geojson
end

end
