var MapControl = (function($) {
  'use strict';
  
  // メニュービューモデル
  var MenuViewModel = function() {
    var self = this;

    // 位置情報のリスト
    self.lists = ko.observableArray();
    // 選択中のListItemModel
    self.listSelected = ko.observable();
    // 選択中のListItemModel変更時イベント
    self.listSelected.subscribe(function(model) {
      if (model) {
        self.loadList(model);
      } else {
        self.resetList();
      }
    });

    // グループ一覧
    self.groups = ko.observableArray();
    // 選択中のグループ名
    self.groupNames = ko.observableArray();

    // ポリゴン一覧
    self.polygons = ko.observableArray();
    // 選択中のポリゴンid
    self.polygonId = ko.observable();
    // 選択中のポリゴンに紐づくPolygonItemModel
    self.polygonSelected = ko.computed(function() {
      // 全polygonsを走査し、polygonSelectedとidの一致する
      // PolygonItemModelを抽出する
      return $.grep(self.polygons(), function(item, idx) {
        return self.polygonId() === item.id();
      })[0];
    });
    // マップから全ポリゴンを削除する
    self.resetPolygon = function() {
      $.each(self.polygons(), function(idx, item) {
        // 全てのポリゴンについて処理する
        $.each(item.features.removeAll(), function() {
          // removeAll()を実行すると削除したデータ(featureの配列)を返す
          // 返されたfeatureをマップから削除する
          mapView.map().data.remove(this);
        });
      });
    };

    // ポイント一覧
    self.points = ko.observableArray();
    // 選択中のポイントに紐づくPointItemModel
    self.pointSelected = ko.observableArray();
    // 地図に表すマーカーの使用状況
    // 配列長: 最大マーカー表示数
    // データ: true-マーカー使用中 false-マーカー未使用
    self.pointUsing = ko.observableArray();
    // マップから全ポイントを削除する
    self.resetPoint = function() {
      $.each(self.points(), function(idx, item) {
        // 全てのポリゴンに ついて処理する
        $.each(item.features.removeAll(), function() {
          // removeAll()を実行すると削除したデータ(featureの配列)を返す
          // 返されたfeatureをマップから削除する
          mapView.map().data.remove(this);
        });
      });
    };

    // 初期化処理
    // リスト一覧の読み込み
    $.getJSON(API+'/list')
    .done(function(json, status, xhr) {
      $.each(json, function(idx, item){
        self.lists.push(new ListItemModel(item));
      });
      // 先頭の組織を選択
      self.listSelected(self.lists()[0]);
    })
    .fail(function(xhr, status, exception){
      console.debug(xhr, status, exception);
    });

    // リストのリセット
    self.resetList = function() {
      self.resetPolygon();
      self.resetPoint();
      self.pointSelected.removeAll();
      self.groupNames.removeAll();
      self.groups.removeAll();
      self.polygons.removeAll();
      self.points.removeAll();
      self.pointUsing = ko.observableArray(
        [false, false, false, false, false]);
        //[false, false, false, false, false, false, false, false, false, false]);
      mapView.clear();
    };

    // リストの読み込み
    self.loadList = function(model) {
      // リストのリセット
      self.resetList()
      // リスト定義データの読み込み
      $.getJSON(API+'/list/'+model.id())
      .done(function(json, status, xhr) {

        // 地図をデフォルト座標に移動する
        var map = mapView.map();
        map.setCenter(new google.maps.LatLng(model.maps().lat, model.maps().lng));
        map.setZoom(model.maps().zoom);

        // リストデータを作成する
        $.each(json.groups, function(idx, item){
          self.groups.push(new GroupItemModel({ name:item }));
        });
        $.each(json.groups, function(idx, item){
          self.groupNames.push(item);
        });
        self.polygons.push(new PolygonItemModel({ id:'', name:'選択なし', group:'', vm:self }));
        self.polygonId('');
        $.each(json.polygons, function(idx, item){
          self.polygons.push(new PolygonItemModel({ id:item.id, name:item.name, group:item.group, vm: self }));
        });
        $.each(json.points, function(idx, item){
          self.points.push(new PointItemModel({ id: item.id, name: item.name, group: item.group, vm: self }));
        });
      })
      .fail(function(xhr, status, exception){
        console.debug(xhr, status, exception);
      });
    }

  }

  //リストモデル
  var ListItemModel = function(params) {
    var self = this;
    // モデルのid
    self.id = ko.observable(params.id);
    // モデル名
    self.name = ko.observable(params.name);
    // マップ情報
    self.maps = ko.observable(params.maps);
  };

  // グループモデル
  var GroupItemModel = function(params) {
    var self = this;
    // モデルの名称
    self.name = ko.observable(params.name);
  };

  // ポリゴンモデル
  var PolygonItemModel = function(params) {
    var self = this;
    // 親オブジェクト(ViewModel)
    self.vm = ko.observable(params.vm);
    // モデルのid
    self.id = ko.observable(params.id);
    // モデルの名称
    self.name = ko.observable(params.name);
    // モデルのグループ
    self.group = ko.observable(params.group);
    // モデルに紐づくfeature
    self.features = ko.observableArray();

    // 表示状態
    self.visible = ko.computed(function() {
      if ('' === self.group()) {
        return true;
      }
      return 0 <= $.inArray(self.group(), self.vm().groupNames());
    })

    // ポリゴンクリックイベント
    self.click = function(model) {
      // 最初に全てのポリゴンを消去する
      model.vm().resetPolygon();

      // 選択したモデルにidが存在する場合は
      // GeoJSONデータを取得し、マップに表示する
      if ('' !== model.id()) {
        // 選択中の組織
        var org = self.vm().listSelected().id();

        // データの取得
        $.getJSON(API+'/data/polygon/'+org+'/'+model.id())
        //$.getJSON(API+'/data/polygon/'+model.id())
        .done(function(json, status, xhr) {
          var geoJsonOptions = {
            //idPropertyName: 'id'
          };
          var features = mapView.map().data.addGeoJson(json, geoJsonOptions);
          model.features(features);
        })
        .fail(function(xhr, status, exception){
          console.debug(xhr, status, exception);
        });
      }
      // モデルを選択状態にするためにtrueを返す
      return true;
    }
  };

  // ポイントモデル
  var PointItemModel = function(params) {
    var self = this;
    // 親オブジェクト(ViewModel)
    self.vm = ko.observable(params.vm);
    // モデルのid
    self.id = ko.observable(params.id);
    // モデルの名称
    self.name = ko.observable(params.name);
    // モデルのグループ
    self.group = ko.observable(params.group);  
    // モデルに与えられるインデクス番号
    // マーカーの使用状況に対応する
    self.markeridx = ko.observable(null);
    // モデルの選択状態
    self.checked = ko.observable(false);
    // モデルに紐づくfeature
    self.features = ko.observableArray();

    // 表示状態
    self.visible = ko.computed(function() {
      return 0 <= $.inArray(self.group(), self.vm().groupNames());
    })

    // ポイントクリックイベント
    self.click = function(model) {
      // モデルの選択状態による処理分岐
      if (model.checked()) {
        // モデルが選択された場合は地図を描画する

        // マーカーの使用状況を検索し、使用可能なマーカー残数を取得する
        var enabled = $.grep(model.vm().pointUsing(), function(item, idx) {
          return false == item;
        }).length;
        // マーカー残数がない場合はモデルの選択を解除し(チェックを受け付けない)終了する
        if (0 === enabled) {
          return false;
        }

        // GeoJSONデータを取得し、マップに表示する
        $.getJSON(API+'/data/point/'+model.id())
        .done(function(json, status, xhr) {
          // マーカーの使用状況を先頭から順に走査し、
          // 最初に見つかった未使用のインデクスを
          // モデルのインデクスとする
          $.each(model.vm().pointUsing(), function(idx, item) {
            if (false == item) {
              model.vm().pointUsing()[idx] = true;
              model.markeridx(idx);
              return false;
            }
          });

          // 選択中のポイントにモデルを追加する
          model.vm().pointSelected.push(model);

          // GeoJSON中の全てのfeatureに対し、マーカーの属性を付加する
          // (マーカーで使用する画像を決定する)
          $.each(json.features, function(idx, feature) {
            feature.properties['__markeridx'] = model.markeridx();
          });
          //console.debug(json.features);

          // 地図にマーカーを表示する
          var geoJsonOptions = {
            //idPropertyName: 'id'
          };
          var features = mapView.map().data.addGeoJson(json, geoJsonOptions);
          model.features(features);
        })
        .fail(function(xhr, status, exception){
          console.debug(xhr, status, exception);
        });
      } else {
        // モデルが非選択の場合は地図を削除する

        // PointItemModelに紐付いたfeatureを削除する
        $.each(model.features.removeAll(), function() {
          // removeAll()を実行すると削除したデータ(featureの配列)を返す
          // 返されたfeatureをマップから削除する      
          mapView.map().data.remove(this);
        });

        // 選択中のポイントからモデルを削除する
        model.vm().pointSelected.remove(function(item) {
          return item.id == model.id;
        });

        // 地図に表すマーカーの使用状況をクリア(未選択化)する
        var idx = model.markeridx();
        model.markeridx(null);
        model.vm().pointUsing()[idx] = false;
      }
      // モデルを選択状態にするためにtrueを返す
      return true;
    }
    
  };

  var API = 'api';
  var mapView = null;

  var MapViewModel = {
    init: function(params) {
      mapView = params.mapView;

      ko.applyBindings({
        menuViewModel: new MenuViewModel(),
        mapViewModel: mapView.viewModel()
      });
    }
  };

  return MapViewModel;
})(jQuery);
