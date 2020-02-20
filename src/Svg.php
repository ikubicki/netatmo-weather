<?php

namespace Irekk\Netatmo;

class Svg
{

    public function renderWind($records, $multiplier_y)
    {
        $document = new Svg\Document;
        $document->multiplier_y = $multiplier_y;
        $document->offset_y = $multiplier_y;
        
        $gradient1 = $document->createGradient('gradient_wind_1');
        $gradient1->fill = '#c8e7fc';
        $gradient1->stroke = '#3af';
        
        $gradient2 = $document->createGradient('gradient_wind_2');
        $gradient2->fill = '#e1eff9';
        $gradient2->stroke = '#aadafc';
        
        $gradient3 = $document->createGradient('gradient_wind_3');
        $gradient3->start = 0;
        $gradient3->end = 75;
        $gradient3->fill = '#fff';
        $gradient3->stroke = '#eee';
        
        $gradient4 = $document->createGradient('gradient_wind_4');
        $gradient4->start = 0;
        $gradient4->end = 75;
        $gradient4->fill = '#fff';
        $gradient4->stroke = '#ddd';
        
        // old
        
        $poly2 = $document->createPolygon();
        $poly2->fill = $gradient3;
        $poly2->stroke = 'none';
        $poly2->stroke_width = 0;
        $poly2->id = "old_poly_gust";
        
        $poly1 = $document->createPolygon();
        $poly1->fill = $gradient4;
        $poly1->stroke = 'none';
        $poly1->stroke_width = 0;
        $poly1->id = "old_path_wind";
        
        $path2 = $document->createPath();
        $path2->stroke = '#ddd';
        $path2->id = 'old_path_gust';
        
        $path1 = $document->createPath();
        $path1->stroke = '#ccc';
        $path1->id = 'old_path_wind';
        
        // current
        
        $poly4 = $document->createPolygon();
        $poly4->fill = $gradient2;
        $poly4->stroke = 'none';
        $poly4->stroke_width = 0;
        $poly4->id = "current_poly_gust";
        
        $path4 = $document->createPath();
        $path4->stroke = '#aadafc';
        $path4->id = 'current_path_gust';
        
        $poly3 = $document->createPolygon();
        $poly3->fill = $gradient1;
        $poly3->stroke = 'none';
        $poly3->stroke_width = 0;
        $poly3->id = "current_path_wind";
        
        $path3 = $document->createPath();
        $path3->stroke = '#3af';
        $path3->id = 'current_path_wind';
        
        $count = 0;
        $max = -999;
        $previous_record = null;
        foreach ($records as $record) {
            if ($max < $record->gust) {
                $max = $record->gust;
            }
            if (date('d', $record->date) != date('d')) {
                
                $path1->addPoint($count, $record->actual);
                $path2->addPoint($count, $record->gust);
                $poly1->addPoint($count, $record->actual);
                $poly2->addPoint($count, $record->gust);
                
                $previous_record = $record;
            }
            else {
                if ($previous_record) {
                    $path1->addPoint($count, $record->actual);
                    $path2->addPoint($count, $record->gust);
                    $poly1->addPoint($count, $record->actual);
                    $poly2->addPoint($count, $record->gust);
                    $previous_record = null;
                }
                
                $path3->addPoint($count, $record->actual);
                $path4->addPoint($count, $record->gust);
                $poly3->addPoint($count, $record->actual);
                $poly4->addPoint($count, $record->gust);
            }
            $count++;
        }
        
        $poly1->max_y = $max;
        $poly2->max_y = $max;
        $poly3->max_y = $max;
        $poly4->max_y = $max;
        $path1->max_y = $max;
        $path2->max_y = $max;
        $path3->max_y = $max;
        $path4->max_y = $max;
        return $document->render();
    }
    
    public function renderRain($records, $multiplier_y)
    {
        $document = new Svg\Document;
        $document->multiplier_y = $multiplier_y;
        $document->offset_y = $multiplier_y;
        
        $gradient1 = $document->createGradient('gradient_rain_1');
        $gradient1->fill = '#f0f7fc';
        $gradient1->stroke = '#c3e5fd';
        
        $gradient2 = $document->createGradient('gradient_rain_2');
        $gradient2->fill = '#e1eff9';
        $gradient2->stroke = '#aadafc';
        
        $gradient3 = $document->createGradient('gradient_rain_3');
        $gradient3->fill = '#c8e7fc';
        $gradient3->stroke = '#3af';
        
        $gradient4 = $document->createGradient('gradient_rain_4');
        $gradient4->start = 0;
        $gradient4->end = 75;
        $gradient4->fill = '#fff';
        $gradient4->stroke = '#f4f4f4';
        
        $gradient5 = $document->createGradient('gradient_rain_5');
        $gradient5->start = 0;
        $gradient5->end = 75;
        $gradient5->fill = '#fff';
        $gradient5->stroke = '#eee';
        
        $gradient6 = $document->createGradient('gradient_rain_6');
        $gradient6->start = 0;
        $gradient6->end = 75;
        $gradient6->fill = '#fff';
        $gradient6->stroke = '#e4e4e4';
        
        // old
        
        $poly3 = $document->createPolygon();
        $poly3->fill = $gradient4;
        $poly3->stroke = 'none';
        $poly3->stroke_width = 0;
        $poly3->id = 'old_poly_rain_24';
        
        $path3 = $document->createPath();
        $path3->stroke = '#ddd';
        $path3->id = 'old_path_rain_24';
        
        $poly2 = $document->createPolygon();
        $poly2->fill = $gradient5;
        $poly2->stroke = 'none';
        $poly2->stroke_width = 0;
        $poly2->id = 'old_poly_rain_1';
        
        $path2 = $document->createPath();
        $path2->stroke = '#d5d5d5';
        $path2->id = 'old_path_rain_1';
        
        $poly1 = $document->createPolygon();
        $poly1->fill = $gradient6;
        $poly1->stroke = 'none';
        $poly1->stroke_width = 0;
        $poly1->id = 'old_poly_rain';
        
        $path1 = $document->createPath();
        $path1->stroke = '#ccc';
        $path1->id = 'old_path_rain';
        
        // current
        
        $poly6 = $document->createPolygon();
        $poly6->fill = $gradient1;
        $poly6->stroke = 'none';
        $poly6->stroke_width = 0;
        $poly6->id = 'current_poly_rain_24';
        
        $path6 = $document->createPath();
        $path6->stroke = '#c3e5fd';
        $path6->id = 'current_path_rain_24';
        
        $poly5 = $document->createPolygon();
        $poly5->fill = $gradient2;
        $poly5->stroke = 'none';
        $poly5->stroke_width = 0;
        $poly5->id = 'current_poly_rain_1';
        
        $path5 = $document->createPath();
        $path5->stroke = '#aadafc';
        $path5->id = 'current_path_rain_1';
        
        $poly4 = $document->createPolygon();
        $poly4->fill = $gradient3;
        $poly4->stroke = 'none';
        $poly4->stroke_width = 0;
        $poly4->id = 'current_poly_rain';
        
        $path4 = $document->createPath();
        $path4->stroke = '#3af';
        $path4->id = 'current_path_rain';
        
        $count = 0;
        $max = -999;
        $previous_record = null;
        foreach ($records as $record) {
            $_max = max($record->actual, $record->hour, $record->day) * 100;
            if ($max < $_max) {
                $max = $_max;
            }
            
            if (date('d', $record->date) != date('d')) {
                $path1->addPoint($count, $record->actual * 100);
                $path2->addPoint($count, $record->hour * 100);
                $path3->addPoint($count, $record->day * 100);
                $poly1->addPoint($count, $record->actual * 100);
                $poly2->addPoint($count, $record->hour * 100);
                $poly3->addPoint($count, $record->day * 100);
                $previous_record = $record;
            }
            else {
                if ($previous_record) {
                    $path1->addPoint($count, $record->actual * 100);
                    $path2->addPoint($count, $record->hour * 100);
                    $path3->addPoint($count, $record->day * 100);
                    $poly1->addPoint($count, $record->actual * 100);
                    $poly2->addPoint($count, $record->hour * 100);
                    $poly3->addPoint($count, $record->day * 100);
                    $previous_record = null;
                }
                $path4->addPoint($count, $record->actual * 100);
                $path5->addPoint($count, $record->hour * 100);
                $path6->addPoint($count, $record->day * 100);
                $poly4->addPoint($count, $record->actual * 100);
                $poly5->addPoint($count, $record->hour * 100);
                $poly6->addPoint($count, $record->day * 100);
            }
            $count++;
        }
        
        $poly1->max_y = $max;
        $poly2->max_y = $max;
        $poly3->max_y = $max;
        $poly4->max_y = $max;
        $poly5->max_y = $max;
        $poly6->max_y = $max;
        $path1->max_y = $max;
        $path2->max_y = $max;
        $path3->max_y = $max;
        $path4->max_y = $max;
        $path5->max_y = $max;
        $path6->max_y = $max;
        return $document->render();
    }

    public function renderUnit($records, $multiplier_y)
    {
        $document = new Svg\Document;
        $document->multiplier_y = $multiplier_y;
        $document->offset_y = $multiplier_y;
        
        $gradient1 = $document->createGradient('gradient_unit_1');
        $gradient1->fill = '#e1eff9';
        $gradient1->stroke = '#a4d8fa';
        
        $gradient2 = $document->createGradient('gradient_unit_2');
        $gradient2->start = 0;
        $gradient2->end = 75;
        $gradient2->fill = '#fff';
        $gradient2->stroke = '#eee';
        
        $poly1 = $document->createPolygon();
        $poly1->fill = $gradient2;
        $poly1->stroke = 'none';
        $poly1->stroke_width = 0;
        $poly1->id = 'old_poly_unit';
        
        $path1 = $document->createPath();
        $path1->stroke = '#ccc';
        $path1->id = 'old_path_unit';
        
        $poly2 = $document->createPolygon();
        $poly2->fill = $gradient1;
        $poly2->stroke = 'none';
        $poly2->stroke_width = 0;
        $poly2->id = 'current_poly_unit';
        
        $path2 = $document->createPath();
        $path2->stroke = '#3af';
        $path2->id = 'current_path_unit';
        
        $count = 0;
        $max = -999;
        $previous_record = null;
        foreach ($records as $record) {
            if ($max < $record->actual * 10) {
                $max = $record->actual * 10;
            }
            if (date('d', $record->date) != date('d')) {
                $path1->addPoint($count, $record->actual * 10);
                $poly1->addPoint($count, $record->actual * 10);
                $previous_record = $record;
            }
            else {
                if ($previous_record) {
                    $path1->addPoint($count, $record->actual * 10);
                    $poly1->addPoint($count, $record->actual * 10);
                    $previous_record = null;
                }
                $path2->addPoint($count, $record->actual * 10);
                $poly2->addPoint($count, $record->actual * 10);
            }
            $count++;
        }
        
        $poly1->max_y = $max;
        $path1->max_y = $max;
        $poly2->max_y = $max;
        $path2->max_y = $max;
        
        return $document->render();
    }
}