<?php

namespace App\Services;

use App\Models\AprioriRecommendation;
use App\Models\Movie;


class AprioriService
{




    public function generateTransactions()
    {
        $movies = Movie::select('id', 'listed_in')->get();
        $transactions = [];
        foreach ($movies as $movie) {
            $genres = explode(', ', $movie->listed_in);
            $transactions[] = $genres;
        }
        return $transactions;
    }



    public function calculateSupport($itemset, $transactions)
    {
        $count = 0;
        foreach ($transactions as $transaction) {
            if (array_intersect($itemset, $transaction) === $itemset) {
                $count++;
            }
        }
        return $count / count($transactions);
    }

    public function calculateConfidence($rule, $transactions)
    {
        list($A, $B) = $rule;
        $support_A = $this->calculateSupport($A, $transactions);
        $support_AB = $this->calculateSupport(array_merge($A, $B), $transactions);
        return $support_AB / $support_A;
    }


    public function apriori($transactions, $minSupport, $minConfidence)
    {
        $items = [];
        foreach ($transactions as $transaction) {
            foreach ($transaction as $item) {
                if (!in_array($item, $items)) {
                    $items[] = $item;
                }
            }
        }
         

        $itemsets = [];
        foreach ($items as $item) {
            $itemsets[] = [$item];
        }
        

        $frequentItemsets = [];
        while (!empty($itemsets)) {
            $nextItemsets = [];
            foreach ($itemsets as $itemset) {
                $support = $this->calculateSupport($itemset, $transactions);
                if ($support >= $minSupport) {
                    $frequentItemsets[] = $itemset;
                    foreach ($items as $item) {
                        if (!in_array($item, $itemset)) {
                            $nextItemset = array_merge($itemset, [$item]);
                            sort($nextItemset);
                            if (!in_array($nextItemset, $nextItemsets)) {
                                $nextItemsets[] = $nextItemset;
                            }
                        }
                    }
                }
            }
            $itemsets = $nextItemsets;
        }
        
        

        $rules = [];
        foreach ($frequentItemsets as $itemset) {
            if (count($itemset) > 1) {
                for ($i = 0; $i < count($itemset); $i++) {
                    $A = array_slice($itemset, 0, $i);
                    $B = array_slice($itemset, $i, 1);
                    if(!empty($A)){
                    $confidence = $this->calculateConfidence([$A, $B], $transactions);
                    if ($confidence >= $minConfidence) {
                        $rules[] = ['antecedent' => $A, 'consequent' => $B, 'confidence' => $confidence ,'support'=> $support ];
                    }}
                }
            }
        }
        return $rules;
        
    }



    public function generateRecommendations($support, $confidence)
    
    { 

        
        $transactions=$this->generateTransactions();

        $rules = $this->apriori($transactions, $support, $confidence);
        
        
       

        
        foreach($rules as $rule)
            AprioriRecommendation::create([
                'itemA' => implode(',', $rule['antecedent']),
                'itemB' => implode(',', $rule['consequent']),
                'confidence' => $rule['confidence'],
                'support' => $rule['support'],
                            
                        ]);
                        
    }
}

            
                
            
        

        
        

        

