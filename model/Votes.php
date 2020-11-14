<?php

require_once('Manager.php');

class Votes extends Manager
{

    protected function listComments()
    {

    }

    protected function editComment($id)
    {

    }

    public function addVote(array $vote)
    {
        $db = $this->dbConnect();
        $newVote = $db->prepare('INSERT INTO votes (user_id, post_id, value) VALUES (:userId, :postId, :value)');

        $newVote = $newVote->execute([
            'userId' => $vote['userId'],
            'postId' => $vote['postId'],
            'value' => $vote['value']
        ]);

        return $newVote;
    }

    protected function deleteComment($id)
    {
        
    }
}