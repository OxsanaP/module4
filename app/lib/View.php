<?php
namespace app\lib;
use app\models\Comments;
class View
{
    protected $_layout;
    protected $_headerTitle;
    protected $_template;
    protected $_params;
    protected $_session;

    public function render($template, $data = null)
    {

        if (is_array($data)) {
            $object = new \StdClass;
            foreach ($data as $key => $value) {
                $object->{$key} = $value;
            }
            $this->setParams($object);
        }
        $this->setTemplate($template);

        include BP . "/views/" . $this->getLayout();
    }

    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }

    public function getLayout()
    {
        return $this->_layout;
    }

    public function setHeaderTitle($title)
    {
        $this->_headerTitle = $title;
        return $this;
    }

    public function getHeaderTitle()
    {
        return $this->_headerTitle;
    }

    protected function setTemplate($template)
    {
        $this->_template = $template . '.php';
        return $this;
    }

    protected function getTemplate()
    {
        return $this->_template;
    }

    protected function setParams($params)
    {
        $this->_params = $params;
        return $this;
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function getContent()
    {
        include BP . "/views/" . trim($this->getTemplate());
    }

    public function upperFirstLetter($str, $encoding = 'UTF8')
    {
        return
            mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) .
            mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
    }

    public function cutText($str, $len, $encoding = 'UTF8')
    {
        return mb_substr($str, 0, $len, $encoding);
    }

    protected function getSession()
    {
        if (null === $this->_session) {
            $this->_session = new Session();
        }
        return $this->_session;
    }

    public function getErrorMessage()
    {
        return $this->getSession()->getErrorMessage();
    }

    public function getSuccessMessage()
    {
        return $this->getSession()->getSuccessMessage();
    }

    public function isLogined()
    {
        return $this->getSession()->isLogined();
    }

    public function getCurrentUserId()
    {
        return $this->getSession()->getUserId();
    }

    public function getCurrentUserName()
    {
        return $this->getSession()->getUserName();
    }

    public function getCommentData($id)
    {
        $html = '';
        $data = $this->getParams()->comments;
        if (!isset($data['other'][$id])) {
            return '';
        }
        foreach ($data['other'][$id] as $comment) {
            $html .='<div class="row">
                <div class="col-sm-offset-1 col-md-11">
                    <div class="comment">
                        <p class="comment-header"> 
                            <span class="comment-like">
                            <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true" data-val="' . $comment['id'] . '"></span>
                            <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true" data-val="' . $comment['id'] . '"></span>
                        </span>

                        <strong>' . $comment['username'] . '</strong></p>
<p class="comment-body">' . $comment['content'] . '</p>
<p class="comment-footer">';
if ($comment['user_id']== $this->getCurrentUserId()) {
    $html .= '<a href="#" class="edit-comment" data-val="' . $comment['id'] . '" > Edit</a >';
}
$html .='<a href="#" class="reply-comment" data-val="' . $comment['id'] . '">Reply</a>
<div class="row">
    <form class="form-horizontal comment-form js-comment-form-' . $comment['id'] . '" method="POST" action="/comment/add">
        <div class="col-md-12">
            <div class="form-group">
                <label for="contentComment" class="col-sm-2 control-label">Comment</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="contentComment" name="content"></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="news_id" value="' . $comment['news_id'] . '">
                <input type="hidden" name="parent_id" value="' . $comment['id'] . '">
                <button type="submit" class="btn btn-default">Add comment</button>
            </div>
        </div>
    </form>
</div>
</p>
</div>';
            $html .= $this->getCommentData($comment['id']);
            $html .= '</div>';
            $html .= '</div>';
        }
        return $html;
    }

    public function getTop()
    {
        $model = new Comments();
        return $model->getTopComentators();
    }

}