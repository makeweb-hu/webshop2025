<?php
namespace app\components;

class XmlToArray {

    public function load_dom($xml) {
        $node=simplexml_import_dom($xml);
        return $this->add_node($node);
    }

    public function load_string($s) {
        $node=simplexml_load_string($s);
        return $this->add_node($node);
    }

    private function add_node($node, &$parent=null, $namespace='', $recursive=false) {

        $namespaces = $node->getNameSpaces(true);
        $content="$node";

        $r['name']=$node->getName();
        if (!$recursive) {
            $tmp=array_keys($node->getNameSpaces(false));
            $r['namespace']=$tmp[0];
            $r['namespaces']=$namespaces;
        }
        if ($namespace) $r['namespace']=$namespace;
        if ($content) $r['content']=$content;

        foreach ($namespaces as $pre=>$ns) {
            foreach ($node->children($ns) as $k=>$v) {
                $this->add_node($v, $r['children'], $pre, true);
            }
            foreach ($node->attributes($ns) as $k=>$v) {
                $r['attributes'][$k]="$pre:$v";
            }
        }
        foreach ($node->children() as $k=>$v) {
            $this->add_node($v, $r['children'], '', true);
        }
        foreach ($node->attributes() as $k=>$v) {
            $r['attributes'][$k]="$v";
        }

        $parent[]=&$r;
        return $parent[0];

    }

}