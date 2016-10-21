<?php
    function update_user_name($id, $name){
        require __DIR__.'/../seed.php';
        $sql = 'UPDATE users SET name=:name WHERE id=:id';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        
        $pdo = null; 
    }

function update_user_email($id, $email){
          require __DIR__.'/../seed.php';
        $sql = 'UPDATE users SET email=:email WHERE id=:id';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    
    
    $pdo = null; 
}
function search_for_users($search){
    require __DIR__.'/../seed.php';
    
    $search_with_wildcards = '%'.$search.'%';
    
    $statement = $pdo->prepare('SELECT * FROM users WHERE name LIKE :search;');
    $statement->bindValue(':search', $search_with_wildcards, PDO::PARAM_STR);
    $statement->execute();
    
    return $statement->fetchAll();
}
?>